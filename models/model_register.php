<?php

class Model_Register extends Model {
    public function register($login, $pass) {
        if ($this->conn != NULL) {
            try {
                $stmt = $this->conn->prepare("SELECT * FROM user WHERE login = ? AND password = ?");
                $stmt->execute(array($login, $pass));
                
                if (count($stmt->fetchAll()) == 0) {
                    $stmt = $this->conn->prepare("INSERT INTO user (login, password) VALUES (?, ?)");
                    $stmt->execute(array($login, $pass));

                    return true;
                }
                else {
                    return false;
                }
            } catch (Throwable $th) {
                return false;
            }
        }
        else return false;
    }
}