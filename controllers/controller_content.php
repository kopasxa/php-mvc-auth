<?php

class Controller_Content extends Controller {
    function __construct() {
        parent::__construct();
		$this->model = new Model();
    }
    
    function action_index() {
        if ($_SESSION["isAuth"]) {
            $isAuth = $this->model->getAuthorizedUser($_SESSION["isAuth"]);

            if ($isAuth) {
                $this->view->generate('content_view.php', 'index_view.php', $_SESSION["isAuth"]);
                return;
            }
        }

		$this->view->generate('login_view.php', 'index_view.php');
	}
}