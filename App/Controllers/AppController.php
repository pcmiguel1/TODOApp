<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function login() {

        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';

        if (isset($_POST['sign_in'])) {
            
            $user = Container::getModel('User');

            $user->__set('user', $_POST['user']);
            $user->__set('senha', md5($_POST['senha']));

            $user->login();

            if($user->__get('id') != '') {
                
                session_start();

                $_SESSION['id'] = $user->__get('id');

                header('location: /');

            } else {
                header('Location: /login?login=error');
            }

        }
        else {
            $this->render('login');
        }

    }



}


?>