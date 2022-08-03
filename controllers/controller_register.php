<?php

class Controller_Register extends Controller {
	function __construct() {
        parent::__construct();
		$this->model = new Model_Register();
    }

    function action_index() {
		if ($_SESSION["isAuth"]) {
            $isAuth = $this->model->getAuthorizedUser($_SESSION["isAuth"]);

            if ($isAuth) {
                header('Location: /content');
            }
        }

		$this->view->generate('register_view.php', 'index_view.php');
	}

	function action_auth() {
        $login = htmlspecialchars($_POST["login"]);
        $pwd = htmlspecialchars($_POST["password"]);

        if (isset($login) && isset($pwd)) {
            $isAuth = $this->model->getAuthorizedUser($login);

            if ($isAuth) {
                $_SESSION["isAuth"] = $login;
                header('Location: /content');
                return;
            }

            $result = $this->model->register($login, md5($pwd));

            if ($result) {
                $token = $this->model->createSecureToken($login);
                $res = $this->model->setAuthorizedUser($login, $token);
            
                if ($res == false) {
                    echo 'error in set token';
                }
                else {
                    $_SESSION["isAuth"] = $login;
					header('Location: /content');
				}
            }
            else {
                echo 'user not found';
            }
        }
        else {
            echo 'error';
        }
    }
}