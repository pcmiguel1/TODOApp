<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function loja() {

        $this->carrinhoQuantidade();

        $this->view->onlineplayers = $this->onlinePlayers();

        //Carregar categorias
        $categoria = Container::getModel('Categoria');
        $all = $categoria->getAll();
        $this->view->allcategorias = $all;

        //selecionar categoria
        $categoria_id = isset($_GET['c']) ? $_GET['c'] : '';

        if (!empty($categoria_id)) {

            $pacote = Container::getModel('Pacote');
            $pacote->__set('id_categoria', $categoria_id);
            $this->view->pacotesCategoria = $pacote->getAllCategoria();

            $this->render('loja');

        } else {
            $this->render('loja');
        }
    }

    public function regras() {

        $this->carrinhoQuantidade();

        $this->view->onlineplayers = $this->onlinePlayers();

        $this->render('regras');
    }

    public function punicoes() {

        $this->carrinhoQuantidade();

        $this->view->onlineplayers = $this->onlinePlayers();

        $this->render('punir');
    }

    public function equipe() {

        $this->carrinhoQuantidade();

        $this->view->onlineplayers = $this->onlinePlayers();

        $this->render('equipe');
    }

    public function aplicar() {

        $this->carrinhoQuantidade();

        $this->view->onlineplayers = $this->onlinePlayers();

        $this->render('aplicar');
    }

    public function carrinho() {

        $this->carrinhoQuantidade();

        $this->view->onlineplayers = $this->onlinePlayers();

        $this->view->coupon = isset($_GET['coupon']) ? $_GET['coupon'] : '';
        $this->view->desconto = 0;

        $acao= isset($_GET['acao']) ? $_GET['acao'] : '';
        if(!empty($acao)) {
            if($acao == 'coupon') {
                $coupon = Container::getModel('Coupon');
                $coupon->__set('nome', $_POST['coupon']);

                if($coupon->getDesconto() > 1) {
                    //se existir o codigo
                    $this->view->desconto = ($coupon->getDesconto()['desconto'] / 100);
                    $this->render('carrinho');
                }
                else {
                    header('Location: /carrinho?coupon=erro');
                }
            }
        } else {
            $this->render('carrinho');
        }
    }

    public function conta() {

        $this->validaLogin();

        $this->view->alterar = isset($_GET['alterar']) ? $_GET['alterar'] : '';
        $this->render('conta');
    }

    public function admin() {

        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
        $this->render('admin');
    }

    public function dashboard() {

        $this->validaLogin();

        if($_SESSION['id'] != '') {
            $this->render('dashboard');
        } else {
            header('Location: /admin?login=erro');
        }

    }

    public function noticias() {

        $this->validaLogin();

        //Colocar as noticias
        $noticia = Container::getModel('Noticia');
        $all = $noticia->getAll();
        $this->view->allnoticias = $all;

        $this->render('noticias');
    }

    public function publicar() {

        $this->validaLogin();

        if(!empty($_POST['titulo']) && !empty($_POST['texto']) && !empty($_POST['autor'])) {

            $noticia = Container::getModel('Noticia');
            $noticia->__set('titulo', $_POST['titulo']);
            $noticia->__set('texto', $_POST['texto']);
            $noticia->__set('autor', $_POST['autor']);

            $noticia->criarNoticia();

            header('Location: /noticias');

        }

    }

    public function criarnoticia() {

        $this->validaLogin();

        $this->render('criarnoticia');
    }

    public function atualizar() {

        $this->validaLogin();

        $id= isset($_GET['id']) ? $_GET['id'] : '';
        $acao= isset($_GET['acao']) ? $_GET['acao'] : '';

        if (!empty($id) && !empty($acao)) {
            if ($acao == "pacote") {
                $pacote = Container::getModel('Pacote');
                $pacote->__set('id', $id);
                $pacote->__set('nome', $_POST['nome']);
                $pacote->__set('descricao', $_POST['desc']);
                $pacote->__set('preco', $_POST['preco']);
                $pacote->__set('img_url', $_POST['pacote-url']);
                $pacote->__set('id_categoria', $_POST['categoria']);
                $pacote->atualizarPacote();

                header('Location: /pacotes');
            }
            if ($acao == "noticia") {
                $noticia = Container::getModel('Noticia');
                $noticia->__set('id', $id);
                $noticia->__set('titulo', $_POST['titulo']);
                $noticia->__set('texto', $_POST['texto']);
                $noticia->__set('autor', $_POST['autor']);
                $noticia->atualizarNoticia();
            
                header('Location: /noticias');
            }
            if($acao == 'coupon') {

                $coupon = Container::getModel('Coupon');
                $coupon->__set('id', $id);
                $coupon->__set('nome', $_POST['codigo']);
                $coupon->__set('desconto', $_POST['desconto']);
                $coupon->__set('max_usos', $_POST['max']);
                $coupon->__set('validade', $_POST['validade']);
                $coupon->atualizarCoupon();

                header('Location: /coupons');
            }
        }
    }

    public function atualizarnoticia() {

        $this->validaLogin();

        $id_noticia = isset($_GET['id']) ? $_GET['id'] : '';

        if (!empty($id_noticia)) {
            $noticia = Container::getModel('Noticia');
            $noticia->__set('id', $id_noticia);
            $n = $noticia->getNoticia();

            $this->view->id = $id_noticia;
            $this->view->titulo = $n['titulo'];
            $this->view->texto = $n['texto'];
            $this->view->autor = $n['autor'];
        }

        $this->render('atualizarnoticia');
    }

    public function validaLogin() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '') {
            header('Location: /admin?login=erro');
        }   

    }

    public function onlinePlayers() {

        $query = file_get_contents('http://mcapi.ca/query/jogar.redehypex.net:25055/info');

        $json = json_decode($query, true);

        return isset($json['players']['online']) ? $json['players']['online'] : 0;

    }

    public function data($dateTime) {
        $data = strtotime($dateTime);

        $dia = date('j', $data);
        $mes = date('m', $data);
        $ano = date('Y', $data);

        return "$dia/$mes/$ano";
    }

    public function acao() {

        $this->validaLogin();

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $pacote_id = isset($_GET['p']) ? $_GET['p'] : '';

        $exec2 = isset($_POST['exec']) ? $_POST['exec'] : '';
        $cmd2 = isset($_POST['comando']) ? $_POST['comando'] : '';

        if (!empty($acao) && !empty($id)) {
            $noticia = Container::getModel('Noticia');
            $noticia->__set('id', $id);

            $pacote = Container::getModel('Pacote');
            $pacote->__set('id', $id);

            $categoria = Container::getModel('Categoria');
            $categoria->__set('id', $id);
    
            if($acao == 'deletar') {
                $noticia->deletarNoticia();
                header('Location: /noticias');
            }
            if($acao == 'dpacote') {
                $pacote->deletarPacote();
                header('Location: /pacotes');
            }
            if($acao == 'dcategoria') {
                $categoria->deletarCategoria();
                header('Location: /pacotes');
            }
        }
        if(!empty($acao)) {

            if($acao == 'novocomando') {

                $id_pacote = isset($_GET['pacote']) ? $_GET['pacote'] : '';
                $exec = isset($_GET['e']) ? $_GET['e'] : '';
                $cmd = isset($_GET['c']) ? $_GET['c'] : '';

                if (!empty($id_pacote) && !empty($exec) && !empty($cmd)) {

                    $comando = Container::getModel('Comando');
                    $comando->__set('exec', $exec);
                    $comando->__set('comando', $cmd);
                    $comando->__set('id_pacote', $id_pacote);
                    $comando->criarComando();

                    header('Location: /atualizarpacote?id='.$id_pacote.'');
                }
            }
        }
        if(!empty($acao) && !empty($id) && !empty($pacote_id)) {

            if($acao == 'deletarcomando') {

                $comando = Container::getModel('Comando');
                
                $comando->__set('id', $id);
                $comando->deletarComando();

                header('Location: /atualizarpacote?id='.$pacote_id.'');
            } 
        }
        if(!empty($exec2) && !empty($cmd2)) {

            if($acao == 'salvarcomando') {

                $comando = Container::getModel('Comando');
                $comando->__set('id', $id);
                $comando->__set('exec', $exec2);
                $comando->__set('comando', $cmd2);
                $teste = $comando->atualizarComando();

                header('Location: /atualizarpacote?id='.$pacote_id.'');
            }  

        }
    }

    public function pacotes() {

        $this->validaLogin();

        //Colocar as categorias
        $categoria = Container::getModel('Categoria');
        $all = $categoria->getAll();
        $this->view->allcategorias = $all;

        $pacote = Container::getModel('Pacote');
        $all = $pacote->getAll();
        $this->view->allpacotes = $all;

        $this->render('pacotes');
    }

    public function criarcategoria() {

        $this->validaLogin();

        if(!empty($_POST['nome'])) {

            $categoria = Container::getModel('Categoria');
            $categoria->__set('nome', $_POST['nome']);

            $categoria->criarCategoria();

            header('Location: /pacotes');

        }

    }

    public function criarpacote() {

        $this->validaLogin();

        if(!empty($_POST['nome']) && !empty($_POST['categoria'])) {

            $pacote = Container::getModel('Pacote');
            $pacote->__set('nome', $_POST['nome']);
            $pacote->__set('id_categoria', $_POST['categoria']);

            $pacote->criarPacote();

            header('Location: /pacotes');

        }

    }

    public function getSize($id_categoria) {

        $pacote = Container::getModel('Pacote');
        return $pacote->getSize($id_categoria)['quant'];

    }

    public function atualizarpacote() {

        $this->validaLogin();

        $id_pacote = isset($_GET['id']) ? $_GET['id'] : '';

        if (!empty($id_pacote)) {
            $pacote = Container::getModel('Pacote');
            $pacote->__set('id', $id_pacote);
            $pacoteget = $pacote->getPacote();
            $this->view->pacote = $pacoteget;

            $categoria = Container::getModel('Categoria');
            $categoria->__set('id', $pacoteget['id_categoria']);

            $this->view->nome_categoria = $categoria->getNomeCategoria()['nome'];

            $all = $categoria->getAll();
            $this->view->allcategorias = $all;

            $comando = Container::getModel('Comando');
            $comando->__set('id_pacote', $id_pacote);
            $this->view->comandos_pacote = $comando->getAllComandosPacote();

        }

        $this->render('atualizarpacote');
    }

    public function detalhes() {

        $this->carrinhoQuantidade();

        $id_pacote = isset($_GET['p']) ? $_GET['p'] : '';

        if (!empty($id_pacote)) {

            $pacote = Container::getModel('Pacote');
            $pacote->__set('id', $id_pacote);

            $this->view->sobrepacote = $pacote->getPacote();

            $this->view->onlineplayers = $this->onlinePlayers();
            $this->render('detalhes');

        }
        else {
            header('Location: /loja');
        }

    }

    public function pagamentos() {

        $this->validaLogin();

        $this->render('pagamentos');
    }

    public function noticia() {

        $this->carrinhoQuantidade();

        $id_noticia = isset($_GET['id']) ? $_GET['id'] : '';

        if (!empty($id_noticia)) {

            $this->view->onlineplayers = $this->onlinePlayers();

            $noticia = Container::getModel('Noticia');
            $noticia->__set('id', $id_noticia);
            $this->view->noticia = $noticia->getNoticia();


            $this->render('noticia');
        }
        else {
            header('Location: /');
        }
    }

    public function carrinhoQuantidade() {

        session_start();

        if(isset($_SESSION["shopping_cart"])) {
            $quantidade = count($_SESSION["shopping_cart"]);
            if($quantidade === 0) {
                $this->view->carrinhoQuantidade = 'Vazio';
            }else {
                $this->view->carrinhoQuantidade = $quantidade;
            }

        } else {
            $this->view->carrinhoQuantidade = 'Vazio';
        }

    }

    public function add() {

        $this->carrinhoQuantidade();

        $id_pacote = isset($_GET['id']) ? $_GET['id'] : '';
        $categoria_id = isset($_GET['c']) ? $_GET['c'] : '';

        if (!empty($id_pacote) && !empty($categoria_id)) {

            $pacote = Container::getModel('Pacote');
            $pacote->__set('id', $id_pacote);
            $p = $pacote->getPacote();

            $categoria = Container::getModel('Categoria');
            $categoria->__set('id', $categoria_id);
            $categoria_nome = $categoria->getNomeCategoria()['nome'];

            if(isset($_SESSION["shopping_cart"]) && $_SESSION["shopping_cart"] != 'Vazio') {

                $item_array_id = array_column($_SESSION["shopping_cart"], "pacote_id");
                if(!in_array($id_pacote, $item_array_id)) {

                    //Se ainda não existir no carrinho
                    $count = count($_SESSION["shopping_cart"]);

                    $item_array = array(
                        'pacote_id'           =>  $id_pacote,
                        'pacote_nome'         =>  $p['nome'],
                        'pacote_servidor'        =>  $categoria_nome,
                        'pacote_preco'     =>  $p['preco'],
                        'pacote_quantidade'     =>  1,
                        'pacote_img'     =>  $p['img_url']
                    );
                    $_SESSION["shopping_cart"][$count] = $item_array;
                }
                else {

                    echo "<pre>";
                    print_r($_SESSION["shopping_cart"]);
                    echo "</pre>";

                    //se já existir no carrinho vai atualizar a quantidade 
                    foreach ($_SESSION["shopping_cart"] as $key => $pacote) {
                        if ($pacote['pacote_id'] == $id_pacote) {
                            $_SESSION["shopping_cart"][$key]['pacote_quantidade'] = $pacote['pacote_quantidade'] + 1;
                        }
                    }

                }

            } else {

                $item_array = array(
                    'pacote_id'           =>  $id_pacote,
                    'pacote_nome'         =>  $p['nome'],
                    'pacote_servidor'        =>  $categoria_nome,
                    'pacote_preco'     =>  $p['preco'],
                    'pacote_quantidade'     =>  1,
                    'pacote_img'     =>  $p['img_url']
                );
                $_SESSION["shopping_cart"][0] = $item_array;
            }

            header('Location: /loja?c='.$categoria_id.'');

        }

    }

    public function del() {

        $this->carrinhoQuantidade();

        $id_pacote = isset($_GET['id']) ? $_GET['id'] : '';

        if (!empty($id_pacote)) {
            if(isset($_SESSION["shopping_cart"]) && $_SESSION["shopping_cart"] != 'Vazio') {
                foreach($_SESSION["shopping_cart"] as $keys => $pacote) {
                    if($pacote["pacote_id"] == $id_pacote) {
                        unset($_SESSION["shopping_cart"][$keys]);
                    }
                }
            }
        }
        header('Location: /carrinho');

    }

    public function coupons() {

        $this->validaLogin();

        $coupon = Container::getModel('Coupon');
        $this->view->allcoupons = $coupon->getAll();

        $this->render('coupons');

    }

    public function criarcoupon() {

        $this->validaLogin();
        $this->view->criar = isset($_GET['criar']) ? $_GET['criar'] : '';

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_coupon = isset($_GET['id']) ? $_GET['id'] : '';

        if(!empty($acao)) {

            $coupon = Container::getModel('Coupon');

            if($acao == 'criar') {

                //Verificar se já existe um coupon com o mesmo código
                $coupon->__set('nome', $_POST['codigo']);

                if($coupon->verificarSeExisteCoupon() > 1) {
                    //se existir
                    header('Location: /criarcoupon?criar=erro');
                }
                else {
                    //se nao existir
                    $coupon->__set('nome', $_POST['codigo']);
                    $coupon->__set('desconto', $_POST['desconto']);
                    $coupon->__set('max_usos', $_POST['max']);
                    $coupon->__set('validade', $_POST['validade']);
                    $coupon->criarCoupon();

                    header('Location: /coupons');
                }
            }
            if($acao == 'deletar') {

                $coupon->__set('id', $id_coupon);
                $coupon->deletarCoupon();

                header('Location: /coupons');
            }

        } else {
            $this->render('criarcoupon');
        }

    }

    public function atualizarcoupon() {

        $this->validaLogin();

        $id_coupon = isset($_GET['id']) ? $_GET['id'] : '';
        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';

        if (!empty($id_coupon)) {
            $coupon = Container::getModel('Coupon');
            $coupon->__set('id', $id_coupon);
            $this->view->coupon = $coupon->getCoupon();

            $this->render('atualizarcoupon');
        }
    }

    public function dataNoticia($dateTime) {

        $data = strtotime($dateTime);
        $diaSemana = date('N', $data);
        $mes = date('n', $data);

        switch ($diaSemana) {
            case '1':
            $diaSemana = "Segunda";
            break;
            case '2':
            $diaSemana = "Terça";
            break;
            case '3':
            $diaSemana = "Quarta";
            break;
            case '4':
            $diaSemana = "Quinta";
            break;
            case '5':
            $diaSemana = "Sexta";
            break;
            case '6':
            $diaSemana = "Sábado";
            break;
            case '7':
            $diaSemana = "Domingo";
            break;

            default:
            break;
        }

        switch ($mes) {
            case '1':
            $mes = "Jan";
            break;
            case '2':
            $mes = "Fev";
            break;
            case '3':
            $mes = "Mar";
            break;
            case '4':
            $mes = "Abr";
            break;
            case '5':
            $mes = "Mai";
            break;
            case '6':
            $mes = "Jun";
            break;
            case '7':
            $mes = "Jul";
            break;
            case '8':
            $mes = "Aug";
            break;
            case '9':
            $mes = "Set";
            break;
            case '10':
            $mes = "Out";
            break;
            case '11':
            $mes = "Nov";
            break;
            case '12':
            $mes = "Dez";
            break;

            default:
            break;
        }
        $dia = date('d', $data);
        $ano = date('yy', $data);
        return "$diaSemana, $dia de $mes $ano";
    }

}


?>