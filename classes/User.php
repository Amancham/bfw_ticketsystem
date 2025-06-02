<?php 
class User {
    private $uid;
    private $username;
    private $password;
    private $email;
    private $pwreset;
    private $role;
    private $created_at;

    public function __construct($user_array)
    {
        if(array_key_exists('uid', $user_array)) {
            $this->uid = $user_array['uid'];
        }
        else {
            $this->uid = 0;
        }
        $this->username = $user_array['username'];
        $this->password = $user_array['password'];
        $this->email = $user_array['email'];
        if(array_key_exists('pwreset', $user_array)) {
            $this->pwreset = $user_array['pwreset'];
        }
        else {
            $this->pwreset = 0;
        }
        if(array_key_exists('role', $user_array)) {
            $this->role = $user_array['role'];
        }
        else {
            $this->role = 'user';
        }
        if(array_key_exists('created_at', $user_array)) {
            $this->created_at = $user_array['created_at'];
        }
        else {
            $this->created_at = time();
        }
    }
    // Getter and Setter
    public function getUid() {
        return $this->uid;
    }
    public function setUid($uid) {
        $this->uid = $uid;
    }

    public function getName() {
        return $this->username;
    }
    public function setName($username) {
        $this->username = $username;
    }

    public function getPwd() {
        return $this->password;
    }
    public function setPwd($password) {
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getPwreset() {
        return $this->pwreset;
    }
    public function setPwreset($pwreset) {
        $this->pwreset = $pwreset;
    }

    public function getRole() {
        return $this->role;
    }
    public function setRole($role) {
        $this->role = $role;
    }

    public function getRegdate() {
        return $this->created_at;
    }
    public function setRegdate($created_at) {
        $this->created_at = $created_at;
    }

    // Other functions
}