<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {
		

		$routes['inicio'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'inicio'
		);

		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'AppController',
			'action' => 'login'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['add'] = array(
			'route' => '/add',
			'controller' => 'AppController',
			'action' => 'add'
		);

		$this->setRoutes($routes);
	}

}

?>