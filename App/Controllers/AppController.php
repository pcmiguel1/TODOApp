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

    public function archive() {

        $this->validaLogin();

        $user = Container::getModel('User');

        $user->__set('id', $_SESSION['id']);

        $this->view->user = $user->getNomeUtilizador();

        $task = Container::getModel('Task');
        $task->__set('user_id', $_SESSION['id']);
        $task->__set('finalizado', True);
        $this->view->tasks = $task->getUserTasks();

        //Adicionar Sections

        $section = Container::getModel('Section');
        $section->__set('user_id', $_SESSION['id']);
        $this->view->sections = $section->getUserSections();

        //Adicionar Categories

        $category = Container::getModel('Category');
        $category->__set('user_id', $_SESSION['id']);
        $this->view->categories = $category->getUserCategories();

        $this->render('archive');
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
            elseif($acao == 'add_task') {

                $task = Container::getModel('Task');
                $task->__set('task_name', $_POST['name']);
                $task->__set('category_id', $_POST['category']);
                $task->__set('section_id', $_POST['section']);
                $task->__set('user_id', $_SESSION['id']);

                $task->addUserTask();
            }
            elseif($acao == 'delete_task') {

                $task = Container::getModel('Task');
                $task->__set('id', $_GET['id']);
                $task->delteUserTask();

            }
            elseif($acao == 'check') {

                $task = Container::getModel('Task');
                $task->__set('id', $_POST['check_id']);
                $task->finalizarUserTask();
            }
            elseif($acao == 'remove_section') {

                $task = Container::getModel('Task');
                $task->__set('user_id', $_SESSION['id']);
                $task->__set('section_id', $_GET['id']);
                $task->deleteTasksSection();

                $section = Container::getModel('Section');
                $section->__set('id', $_GET['id']);
                $section->deleteUserSection();

            }
        } 
        header('location: /');

    }

    public function validaLogin() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '') {
            header('Location: /login?login=error');
        }   

    }



}


?>