<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function inicio() {

        $this->carrinhoQuantidade();

        //colocar o numero de jogadores online
        $query = file_get_contents('http://mcapi.ca/query/jogar.redehypex.com:25055/info');

        $json = json_decode($query, true);

        $this->view->onlineplayers = isset($json['players']['online']) ? $json['players']['online'] : 0;

        //Colocar as noticias
        $noticia = Container::getModel('Noticia');
        $all = $noticia->getAll();
        $this->view->allnoticias = $all;


		$this->render('index');
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

    public function lessTexto($texto) {
        $string = $texto;
        if (strlen($string) > 1000) {

            // truncate string
            $stringCut = substr($string, 0, 1000);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';

        }

        return $string;
    }

    public function textoReadMore($texto) {
        $read = false;
        $string = strip_tags($texto);
        if (strlen($string) > 1000) {
            $read = true;
         } 
         return $read;
    }

}


?>