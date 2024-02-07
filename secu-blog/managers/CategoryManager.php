<?php

class CategoryManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }
    
    public function findAll() : array {
        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findOne( int $id ) : array {
        $query = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $parameters = [
            'id' => $id
            ];
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}