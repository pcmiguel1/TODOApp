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

    public function add() {

        session_start();

        $acao= isset($_GET['acao']) ? $_GET['acao'] : '';
        if(!empty($acao)) {
            if($acao == 'add_section') {
                $section = Container::getModel('Section');
                $section->__set('section_name', $_POST['name_section']);
                $section->__set('user_id', $_SESSION['id']);

                $section->addUserSection();
                
            }
            elseif ($acao == 'add_category') {

                $category = Container::getModel('Category');
                $category->__set('category_name', $_POST['name_category']);
                $category->__set('color', $_POST['color_category']);
                $category->__set('user_id', $_SESSION['id']);

                $category->addUserCategory();

            }
        } 
        header('location: /');

    }



}


?>