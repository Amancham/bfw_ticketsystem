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
            $sql = "INSERT INTO user (username, password, email) VALUES ('".$user->getName()."', '".$user->getEmail()."', '".$user->getPassword()."');";
            $this->pdo->exec($sql);
        }
        else {
            $sql = "UPDATE player SET username = '".$user->getName()."', password = '".$user->getPassword()."', email = '".$user->getEmail()."', pwreset = ".$user->getPwreset().", role = ".$user->getRole().", created_at = ".$user->getCreated_at()." WHERE uid = ".$user->getUid().";";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
    }
}