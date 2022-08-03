<?php

class Model_Login extends Model {
    public function login($login, $pass) {
        if ($this->conn != NULL) {
            try {
                /* $stmt = $this->conn->prepare("INSERT INTO user (login, password) VALUES (?, ?)");
                $stmt->execute(array($login, $pass)); */

                $stmt = $this->conn->prepare("SELECT * FROM user WHERE login = ? AND password = ?");
                $stmt->execute(array($login, $pass));
                
                if (count($stmt->fetchAll()) == 0) {
                    return false;
                }
                else {
                    return true;
                }
            } catch (Throwable $th) {
                return false;
            }
        }
        else return false;
    }
}