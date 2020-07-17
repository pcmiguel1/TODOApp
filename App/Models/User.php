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

}



?>