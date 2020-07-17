<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function inicio() {
        

        $this->validaLogin();

		$this->render('index');
    }
    
    public function validaLogin() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '') {
            header('Location: /login?login=error');
        }   

    }

}


?>