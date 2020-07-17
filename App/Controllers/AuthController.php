<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

    public function sair() {
        session_start();
        session_destroy();
        header('Location: /login');
    }

}


?>