<?php

namespace App\Models;

use MF\Model\Model;


class Task extends Model {

    private $id;
    private $task_name;
    private $category_id;
    private $section_id;
    private $time;
    private $user_id;
    private $finalizado;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function getUserTasks() {
        $query = "select id, task_name, category_id, section_id, time, finalizado from user_tasks where user_id = :user_id and finalizado = :finalizado";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->bindValue(':finalizado', $this->__get('finalizado'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addUserTask() {
        $query = "insert into user_tasks(task_name, category_id, section_id, user_id) values(:task_name,:category_id,:section_id,:user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':task_name', $this->__get('task_name'));
        $stmt->bindValue(':category_id', $this->__get('category_id'));
        $stmt->bindValue(':section_id', $this->__get('section_id'));
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->execute();

        return $this;
    }

    public function delteUserTask() {
        $query = "delete from user_tasks where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
    }

    public function deleteTasksSection() {
        $query = "delete from user_tasks where user_id = :user_id and section_id = :section_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $this->__get('user_id'));
        $stmt->bindValue(':section_id', $this->__get('section_id'));
        $stmt->execute();
    }

    public function finalizarUserTask() {
        $query = "update user_tasks set finalizado = 1 where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
    }

}



?>