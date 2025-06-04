<?php 

class Database {
    private $host;
    private $user;
    private $pwd;
    private $dbase;
    private $pdo;

    public function __construct($host, $user, $pwd, $dbase) {
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->dbase = $dbase;
        $conn = new PDO("mysql:host=".$host.";dbname=".$dbase."", $user, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $conn;
    }

    public function getHost() {
        return $this->host;
    }
    public function setHost($host) {
        $this->host = $host;
    }

    public function getUser() {
        return $this->user;
    }
    public function setUser($user) {
        $this->user = $user;
    }

    public function getPwd() {
        return $this->pwd;
    }
    public function setPwd($pwd) {
        $this->pwd = $pwd;
    }

    public function getDbase() {
        return $this->dbase;
    }
    public function setDbase($dbase) {
        $this->dbase = $dbase;
    }

    public function getPdo() {
        return $this->pdo;
    }
    public function setPdo($pdo) {
        $this->pdo = $pdo;
    }
    
    // functions for loading/saving & signing up user
    public function load_user($uid) {
        $sql = "SELECT * FROM user WHERE uid = ".$uid.";";
        foreach($this->pdo->query($sql) as $row) {
            $_SESSION['uid'] = $row['uid'];
            return new User($row);
        }
    }

    public function get_uid($email) {
        $sql = "SELECT * FROM user WHERE email = '".$email."';";
        foreach($this->pdo->query($sql) as $row) {
            return $row['uid'];
        }
    }

    public function save_user($user) {
        if($user->getUid() == 0) {
            $sql = "INSERT INTO user (username, password, email) VALUES ('".$user->getUsername()."', '".$user->getPassword()."', '".$user->getEmail()."');";
            $this->pdo->exec($sql);
        }
        else {
            $sql = "UPDATE player SET username = '".$user->getUsername()."', password = '".$user->getPassword()."', email = '".$user->getEmail()."', pwreset = ".$user->getPwreset().", role = ".$user->getRole().", created_at = ".$user->getCreated_at()." WHERE uid = ".$user->getUid().";";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
    }

    public function check_signup($username, $email, $password, $password2) {
        // check that everything is correct before saving the user info to the database
        $pattern = "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,}$/";
        $checkstmt = "SELECT * FROM user WHERE email = '".addslashes($email)."';";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if($check_rows > 0) {
            $_SESSION['error_signup'] = "Die E-Mail-Adresse ist bereits vorhanden. Bitte <a href=\"login.php\">melden Sie sich an</a> oder versuchen sie eine andere Adresse zu benutzen.";
            return false;
        }
        elseif($password != $password2) {
            $_SESSION['error_signup'] = "Passwort und Passwort Widerholung stimmen nicht überein.";
            return false;
        }
        elseif(strlen($password) < 10) {
            $_SESSION['error_signup'] = "Das gewählte Passwort ist zu kurz";
            return false;
        }
        // TODO: see about checking for more secure passwords!
        elseif(preg_match($pattern, $email) != 1) {
            $_SESSION['error_signup'] = "Bitte überprüfen Sie ihre E-Mail-Adresse. Die Eingabe scheint keine gültige E-Mail-Adresse zu sein.";
            return false;
        }
        else {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $user_array = [
                'uid' => 0,
                'username' => addslashes($username),
                'password' => $password_hashed,
                'email' => addslashes($email)
            ];
            $user = new User($user_array);
            $this->save_user($user);
            return true;
        }
    }

    public function check_login($email, $password) {
        // check if user exists and password is correct before logging them in
        $checkstmt = "SELECT password FROM user WHERE email = '".addslashes($email)."';";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if($check_rows > 0) {
            $sql = "SELECT * FROM user WHERE email = '".$email."';";
            foreach($this->pdo->query($sql) as $row) {
                $password_hashed = $row['password'];
            }
            if(password_verify($password, $password_hashed)) {
                return true;
            }
            else {
                $_SESSION['error_login'] = "Falsches Passwort";
                return false;
            }
        }
        $_SESSION['error_login'] = "Falsche E-Mail-Adresse.";
        return false;
    }

    public function do_login($email) {
        // check that login info is correct and user exists in the database
        $email_secure = addslashes($email);
        $new_id = $this->get_uid($email_secure);
        $_SESSION['uid'] = $new_id;
        return $this->load_user($new_id);
    }
    
    // admin-related functions
    public function list_users() {
        $stmt = $this->pdo->query("SELECT uid, username,  role FROM user ORDER BY role DESC, username ASC");
        return $stmt->fetchAll();
    }

    public function update_user($new_role, $uid) {
        $stmt = $this->pdo->prepare("UPDATE user SET role = ? WHERE uid = ?");
        $stmt->execute([$new_role, $uid]);
    }
}