<?php

class Database
{
    private $host;
    private $user;
    private $pwd;
    private $dbase;
    private $pdo;

    public function __construct($host, $user, $pwd, $dbase)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->dbase = $dbase;
        $conn = new PDO("mysql:host=" . $host . ";dbname=" . $dbase . "", $user, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $conn;
    }

    public function getHost()
    {
        return $this->host;
    }
    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getPwd()
    {
        return $this->pwd;
    }
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    public function getDbase()
    {
        return $this->dbase;
    }
    public function setDbase($dbase)
    {
        $this->dbase = $dbase;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }

    // functions for loading/saving & signing up user
    public function load_user($uid)
    {
        $sql = "SELECT * FROM user WHERE uid = " . $uid . ";";
        foreach ($this->pdo->query($sql) as $row) {
            $_SESSION['uid'] = $row['uid'];
            return new User($row);
        }
    }

    public function get_uid($email)
    {
        $sql = "SELECT * FROM user WHERE email = '" . $email . "';";
        foreach ($this->pdo->query($sql) as $row) {
            return $row['uid'];
        }
    }

    public function save_user($user)
    {
        if ($user->getUid() == 0) {
            $sql = "INSERT INTO user (username, password, email) VALUES ('" . $user->getUsername() . "', '" . $user->getPassword() . "', '" . $user->getEmail() . "');";
            $this->pdo->exec($sql);
        } else {
            $sql = "UPDATE player SET username = '" . $user->getUsername() . "', password = '" . $user->getPassword() . "', email = '" . $user->getEmail() . "', pwreset = " . $user->getPwreset() . ", role = " . $user->getRole() . ", created_at = " . $user->getCreated_at() . " WHERE uid = " . $user->getUid() . ";";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
    }

    public function check_signup($username, $email, $password, $password2)
    {
        // check that everything is correct before saving the user info to the database
        $pattern = "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,}$/";
        $checkstmt = "SELECT * FROM user WHERE email = '" . addslashes($email) . "';";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if ($check_rows > 0) {
            $_SESSION['error_signup'] = "Die E-Mail-Adresse ist bereits vorhanden. Bitte <a href=\"login.php\">melden Sie sich an</a> oder versuchen sie eine andere Adresse zu benutzen.";
            return false;
        } elseif ($password != $password2) {
            $_SESSION['error_signup'] = "Passwort und Passwort Widerholung stimmen nicht überein.";
            return false;
        } elseif (strlen($password) < 10) {
            $_SESSION['error_signup'] = "Das gewählte Passwort ist zu kurz";
            return false;
        }
        // TODO: see about checking for more secure passwords!
        elseif (preg_match($pattern, $email) != 1) {
            $_SESSION['error_signup'] = "Bitte überprüfen Sie ihre E-Mail-Adresse. Die Eingabe scheint keine gültige E-Mail-Adresse zu sein.";
            return false;
        } else {
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

    public function check_login($email, $password)
    {
        // check if user exists and password is correct before logging them in
        $checkstmt = "SELECT password FROM user WHERE email = '" . addslashes($email) . "';";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if ($check_rows > 0) {
            $sql = "SELECT * FROM user WHERE email = '" . $email . "';";
            foreach ($this->pdo->query($sql) as $row) {
                $password_hashed = $row['password'];
            }
            if (password_verify($password, $password_hashed)) {
                return true;
            } else {
                $_SESSION['error_login'] = "Falsches Passwort";
                return false;
            }
        }
        $_SESSION['error_login'] = "Falsche E-Mail-Adresse.";
        return false;
    }

    public function do_login($email)
    {
        // check that login info is correct and user exists in the database
        $email_secure = addslashes($email);
        $new_id = $this->get_uid($email_secure);
        $_SESSION['uid'] = $new_id;
        return $this->load_user($new_id);
    }


    public function list_categories()
    {
        $checkstmt = "SELECT * FROM category";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if ($check_rows > 0) {
            $sql = "SELECT cid, cname FROM category";
            foreach ($this->pdo->query($sql) as $row) {
                echo ("<a href=\"index.php?cat=" . $row['cid'] . "\"><div class=\"cat_link\">" . $row['cname'] . "</div></a>");
            }
        } else {
            echo ("Es gibt noch keine Rubriken.");
        }
    }

    public function display_category($cid)
    {
        $sql = "SELECT * FROM category WHERE cid = " . (int) $cid . ";";
        foreach ($this->pdo->query($sql) as $row) {
            echo ('<p align="center">' . $row['cat_descr'] . '</p>');
            echo ('<h2>' . $row['cname'] . '</h2>');
        }
    }

    public function select_category()
    {
        $checkstmt = "SELECT * FROM category";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if ($check_rows > 0) {
            echo ("<option value=\"0\">Bitte wählen</option>");
            $sql = "SELECT * FROM category";
            foreach ($this->pdo->query($sql) as $row) {
                echo ('<option value="' . $row['cid'] . '">' . $row['cname'] . '</option>');
            }
        } else {
            echo ("<option value=\"none\" selected>Bitte wählen</option>");
        }
    }

    public function save_category($cid, $cname, $cat_descr)
    {
        if ($cid == 0) {
            $sql = "INSERT INTO category (cname, cat_descr) VALUES ('" . $cname . "', '" . $cat_descr . "');";
            $this->pdo->exec($sql);
            $_SESSION['success_adcat'] = "Rubrik wurde erstellt.";
        } else {
            $sql = "UPDATE category SET cname = '" . $cname . "', cat_descr = '" . $cat_descr . "' WHERE cid = " . $cid . ";";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $_SESSION['success_adcat'] = "Die Rubrik wurde geändert.";
        }
    }

    // functions for loading and saving adverts
    public function load_all_ads()
    {
        // TODO join with user and category table to pull all information!
        $checkstmt = "SELECT * FROM advert a LEFT JOIN user u on a.uid = u.uid LEFT JOIN category c on a.cid = c.cid;";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if ($check_rows > 0) {
            foreach ($this->pdo->query($checkstmt) as $row) {
                $ad = new Advert($row);
                echo ($ad->display_ad_teaser());
            }
        } else {
            echo ("Es wurden noch keine Anzeigen eingetragen.");
        }
    }

    public function load_ads_by_cid($cid)
    {
        $checkstmt = "SELECT * FROM advert a LEFT JOIN user u on a.uid = u.uid LEFT JOIN category c on a.cid = c.cid WHERE a.cid = " . (int) $cid . ";";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if ($check_rows > 0) {
            foreach ($this->pdo->query($checkstmt) as $row) {
                $ad = new Advert($row);
                echo ($ad->display_ad_teaser());
            }
        } else {
            echo ("In dieser Rubrik gibt es noch keine Anzeigen.");
        }
    }

    public function load_ads_by_uid($uid)
    {
        $checkstmt = "SELECT * FROM advert a LEFT JOIN user u on a.uid = u.uid LEFT JOIN category c on a.cid = c.cid WHERE a.uid = " . (int) $uid . ";";
        $check = $this->pdo->prepare($checkstmt);
        $check->execute();
        $check_rows = $check->rowCount();
        if ($check_rows > 0) {
            foreach ($this->pdo->query($checkstmt) as $row) {
                $ad = new Advert($row);
                echo ($ad->display_ad_teaser());
            }
        } else {
            echo ("Sie haben noch keine Anzeigen erstellt.");
        }
    }

    public function check_ad($cid, $title, $price)
    {
        if ($cid == 0) {
            $_SESSION['error_adform'] = "Bitte eine Rubrik auswählen.";
            return false;
        } elseif ($title == '') {
            $_SESSION['error_adform'] = "Bitte einen aussagekräftigen Titel angeben.";
            return false;
        } elseif ($price == '') {
            $_SESSION['error_adform'] = "Bitte einen Preis angeben. Wenn es kostenlos sein soll, einfach 0 eintragen.";
            return false;
        } else {
            return true;
        }
    }

    public function save_ad($ad_array)
    {
        if (array_key_exists('aid', $ad_array)) {
            // update existing ad 
            $sql = "UPDATE advert SET uid = " . $ad_array['uid'] . ", cid = " . $ad_array['cid'] . ", title = '" . $ad_array['title'] . "', ad_descr = '" . $ad_array['ad_descr'] . "', price = " . $ad_array['price'] . ", date = " . $ad_array['date'] . ", visible = " . $ad_array['visible'] . " WHERE aid = " . $ad_array['aid'] . ";";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        } else {
            // insert new ad 
            $sql = "INSERT INTO advert (uid, cid, title, ad_descr, price, visible) VALUES (" . $ad_array['uid'] . ", " . $ad_array['cid'] . ", '" . $ad_array['title'] . "', '" . $ad_array['ad_descr'] . "', " . $ad_array['price'] . ", 1);";
            $this->pdo->exec($sql);
        }
    }


    public function createTicket($title, $description, $priority, $uid, $cid, )
    {
        //$db = new Database('localhost', 'singh', '', 'database');
        
        
        $stmt = $this->pdo->prepare("INSERT INTO ticket (title, description, priority, uid, cid) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $priority, $uid, $cid]);
    }

}