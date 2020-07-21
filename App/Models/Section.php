<?php

namespace App\Models;

use MF\Model\Model;


class Section extends Model {

    private $id;
    private $section_name;
    private $user_id;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function getUserSections() {
        $query = "select id, section_name from user_sections where user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addUserSection() {
        $query = "insert into user_sections(section_name, user_id) values(:section_name,:user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':section_name', $this->__get('section_name'));
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->execute();

        return $this;
    }

    public function deleteUserSection() {
        $query = "delete from user_sections where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        return $this;
    }

}



?>