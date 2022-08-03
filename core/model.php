<?php

include './db/connect.php';

class Model extends Connect_DB {
    protected  $conn;

    public function __construct() {
        $this->conn = new Connect_DB();
        $this->conn = $this->conn->connect();
        
        if ($this->conn == false) {
            echo 'error in connect db';
        }

        if ($_SESSION["isAuth"]) {
            if ($this->getTimeToken($_SESSION["isAuth"])) {
                $this->renewTokenLife($_SESSION["isAuth"]);
            }
        }
    }

    public function createSecureToken($login) {
        return bin2hex(random_bytes(32));
    }

    public function logout($login) {
        
    }

    public function renewTokenLife($login) {
        try {
            $stmt = $this->conn->prepare("UPDATE token SET time = now() WHERE login = ?");
            $stmt->execute(array($login));
            return true;
        }
        catch (Throwable $th) {
            return false;
        }
    }

    public function setAuthorizedUser($login, $token) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO token (login, token) VALUES (?, ?)");
            $stmt->execute(array($login, $token));
            return true;
        }
        catch (Throwable $th) {
            return false;
        }
    }

    public function delAuthorizedUser($login) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM token WHERE login = ?");
            $stmt->execute(array($login));
            return true;
        }
        catch (Throwable $th) {
            return false;
        }
    }

    public function getTimeToken($login) {
        try {
            $stmt = $this->conn->prepare("SELECT time FROM token WHERE login = ?");
            $stmt->execute(array($login));
            
            $result = $stmt->fetchAll();

            //var_dump();

            if (count($result) > 0) {
                $ts1 = strtotime($result[0]["time"]);
                $ts2 = time();     
                $seconds_diff = $ts2 - $ts1;                            
                $time = ($seconds_diff / 60);

                if ($time < 2) {
                    return true;
                }
                else {
                    $this->delAuthorizedUser($login);
                    $_SESSION["isAuth"] = NULL;
                }
            }
            else {
                return false;
            }
            
        }
        catch (Throwable $th) {
            return false;
        }
    }

    public function getAuthorizedUser($login) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM token WHERE login = ?");
            $stmt->execute(array($login));
            
            if (count($stmt->fetchAll()) > 0) {
                return true;
            }
            else {
                return false;
            }
            
        }
        catch (Throwable $th) {
            return false;
        }
    }
}