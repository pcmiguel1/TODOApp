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

		$routes['loja'] = array(
			'route' => '/loja',
			'controller' => 'AppController',
			'action' => 'loja'
		);

		$routes['regras'] = array(
			'route' => '/regras',
			'controller' => 'AppController',
			'action' => 'regras'
		);

		$routes['punicoes'] = array(
			'route' => '/punicoes',
			'controller' => 'AppController',
			'action' => 'punicoes'
		);

		$routes['equipe'] = array(
			'route' => '/equipe',
			'controller' => 'AppController',
			'action' => 'equipe'
		);

		$routes['aplicar'] = array(
			'route' => '/aplicar',
			'controller' => 'AppController',
			'action' => 'aplicar'
		);

		$routes['carrinho'] = array(
			'route' => '/carrinho',
			'controller' => 'AppController',
			'action' => 'carrinho'
		);

		$routes['admin'] = array(
			'route' => '/admin',
			'controller' => 'AppController',
			'action' => 'admin'
		);

		$routes['dashboard'] = array(
			'route' => '/dashboard',
			'controller' => 'AppController',
			'action' => 'dashboard'
		);

		$routes['noticias'] = array(
			'route' => '/noticias',
			'controller' => 'AppController',
			'action' => 'noticias'
		);

		$routes['criarnoticia'] = array(
			'route' => '/criarnoticia',
			'controller' => 'AppController',
			'action' => 'criarnoticia'
		);

		$routes['atualizarnoticia'] = array(
			'route' => '/atualizarnoticia',
			'controller' => 'AppController',
			'action' => 'atualizarnoticia'
		);

		$routes['publicar'] = array(
			'route' => '/publicar',
			'controller' => 'AppController',
			'action' => 'publicar'
		);

		$routes['atualizar'] = array(
			'route' => '/atualizar',
			'controller' => 'AppController',
			'action' => 'atualizar'
		);

		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'AuthController',
			'action' => 'login'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['conta'] = array(
			'route' => '/conta',
			'controller' => 'AppController',
			'action' => 'conta'
		);

		$routes['alterar'] = array(
			'route' => '/alterar',
			'controller' => 'AuthController',
			'action' => 'alterar'
		);

		$routes['acao'] = array(
			'route' => '/acao',
			'controller' => 'AppController',
			'action' => 'acao'
		);

		$routes['coupons'] = array(
			'route' => '/coupons',
			'controller' => 'AppController',
			'action' => 'coupons'
		);

		$routes['pacotes'] = array(
			'route' => '/pacotes',
			'controller' => 'AppController',
			'action' => 'pacotes'
		);

		$routes['criarcategoria'] = array(
			'route' => '/criarcategoria',
			'controller' => 'AppController',
			'action' => 'criarcategoria'
		);

		$routes['criarpacote'] = array(
			'route' => '/criarpacote',
			'controller' => 'AppController',
			'action' => 'criarpacote'
		);

		$routes['atualizarpacote'] = array(
			'route' => '/atualizarpacote',
			'controller' => 'AppController',
			'action' => 'atualizarpacote'
		);

		$routes['detalhes'] = array(
			'route' => '/detalhes',
			'controller' => 'AppController',
			'action' => 'detalhes'
		);

		$routes['pagamentos'] = array(
			'route' => '/pagamentos',
			'controller' => 'AppController',
			'action' => 'pagamentos'
		);

		$routes['noticia'] = array(
			'route' => '/noticia',
			'controller' => 'AppController',
			'action' => 'noticia'
		);

		$routes['add'] = array(
			'route' => '/add',
			'controller' => 'AppController',
			'action' => 'add'
		);

		$routes['del'] = array(
			'route' => '/del',
			'controller' => 'AppController',
			'action' => 'del'
		);

		$routes['criarcoupon'] = array(
			'route' => '/criarcoupon',
			'controller' => 'AppController',
			'action' => 'criarcoupon'
		);

		$routes['atualizarcoupon'] = array(
			'route' => '/atualizarcoupon',
			'controller' => 'AppController',
			'action' => 'atualizarcoupon'
		);
		
		

		$this->setRoutes($routes);
	}

}

?>