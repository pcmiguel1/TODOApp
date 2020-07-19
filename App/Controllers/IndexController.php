<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function inicio() {

        $this->validaLogin();

        $user = Container::getModel('User');

        $user->__set('id', $_SESSION['id']);

        $this->view->user = $user->getNomeUtilizador();

        //Adicionar Sections

        $section = Container::getModel('Section');
        $section->__set('user_id', $_SESSION['id']);
        $this->view->sections = $section->getUserSections();

        //Adicionar Categories

        $category = Container::getModel('Category');
        $category->__set('user_id', $_SESSION['id']);
        $this->view->categories = $category->getUserCategories();

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