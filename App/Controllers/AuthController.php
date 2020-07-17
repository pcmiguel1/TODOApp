<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

    public function login() {
        
        $user = Container::getModel('User');

        $user->__set('user', $_POST['user']);
        $user->__set('senha', md5($_POST['senha']));

        $user->login();

        if($user->__get('id') != '') {
            
            session_start();

            $_SESSION['id'] = $user->__get('id');

            header('location: /dashboard');

        } else {
            header('Location: /admin?login=erro');
        }

    }

    public function sair() {
        session_start();
        session_destroy();
        header('Location: /admin');
    }

    public function alterar() {
        $this->validaLogin();

        $senha = $_POST['senha'];
        $senhaOutra = $_POST['senhaoutra'];

        if(!empty($_POST['senha']) && !empty($_POST['senhaoutra'])) {

            if($_POST['senha'] == $_POST['senhaoutra']) {

                $user = Container::getModel('User');
                $user->__set('id', $_SESSION['id']);
                $user->__set('senha', md5($_POST['senha']));

                $user->updatepassword();

                header('Location: /conta?alterar=sucesso');

            } else {
                header('Location: /conta?alterar=erro');
            }

        }

    }

    public function validaLogin() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '') {
            header('Location: /admin?login=erro');
        }   

    }

}


?>