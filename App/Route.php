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

		$this->setRoutes($routes);
	}

}

?>