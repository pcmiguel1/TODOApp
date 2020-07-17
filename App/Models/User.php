<?php

namespace App\Models;

use MF\Model\Model;


class User extends Model {

    private $id;
    private $user;
    private $senha;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function login() {

        $query = "select id, user from users where user = :user and senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user', $this->__get('user'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($user['id'] != '') {
            $this->__set('id', $user['id']);
        }

        return $this;
    }

    public function updatepassword() {

        $query = "update users set senha = :senha where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        return $this;
    }

    /*
    //salvar registro
    public function salvar() {
        $query = "insert into users(number,admin) values(:number,:admin)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':number', $this->__get('number'));
        $stmt->bindValue(':admin', 0);
        $stmt->execute();

        return $this;
    }

    //validar o registro
    public function validarCadastro() {
        $valido = true;

        if(strlen($this->__get('number')) < 3) {
            $valido = false;
        }

        return $valido;

    }

    //validar se o numero já não está criado
    public function getNumber() {
        $query = "select number from users where number = :number";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':number', $this->__get('number'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //verficar se o id(number) existe
    public function autenticar() {
        $query = "select id, number from users where number = :number";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':number', $this->__get('number'));
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($user['id'] != '') {
            $this->__set('id', $user['id']);
        }

        return $this;
    }

    //Saber o nome do utilizador
    public function getNomeUtilizador() {
        $query = "select name from datauser where idUser = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_user', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //Saber o nome do utilizador
    public function getPrimaryKeyUser($number) {
        $query = "select id from users where number = :number";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':number', $number);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //Verificar se é administrador
    public function checkAdmin() {
        $query = "select admin from users where id = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_user', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }*/

}



?>