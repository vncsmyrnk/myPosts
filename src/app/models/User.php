<?php

class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function findUserByEmail($email) {
        $this->db->query("
            SELECT * FROM USERS WHERE EMAIL = :EMAIL
        ");

        $this->db->bind('EMAIL', $email);

        return $this->db->fetch();
    }

    public function emailExists($email) {
        $thisEmailUser = $this->findUserByEmail($email);

        if (is_object($thisEmailUser)) {
            return true;
        }

        return false;
    }

    public function register($name, $email, $password) {
        $this->db->query("
            INSERT INTO USERS (NAME, EMAIL, PASSWORD) VALUES (:NAME, :EMAIL, :PASSWORD)
        ");

        $this->db->bind('NAME', $name);
        $this->db->bind('EMAIL', $email);
        $this->db->bind('PASSWORD', $password);

        return $this->db->execute();
    }

    public function login($email, $password) {
        $user = $this->findUserByEmail($email);
        if (!is_object($user)) {
            return false;
        }

        $hashed_password = $user->password;
        return password_verify($password, $hashed_password) ? $user : false;
    }
}