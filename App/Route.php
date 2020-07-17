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

		$this->setRoutes($routes);
	}

}

?>