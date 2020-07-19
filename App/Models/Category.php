<?php

namespace App\Models;

use MF\Model\Model;


class Category extends Model {

    private $id;
    private $category_name;
    private $color;
    private $user_id;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function getUserCategories() {
        $query = "select id, category_name, color from user_categories where user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addUserCategory() {
        $query = "insert into user_categories(category_name, color, user_id) values(:category_name,:color,:user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':category_name', $this->__get('category_name'));
        $stmt->bindValue(':color', $this->__get('color'));
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->execute();

        return $this;
    }

}



?>