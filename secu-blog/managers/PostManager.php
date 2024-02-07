<?php

class PostManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }
    
    public function findLatest() : array{
        $query = $this->db->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT 4");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function findOne(int $id) : array{
        $query = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
        $parameters = [
            'id' => $id
            ];
        $query->execute($parameters);
        return !isset($id) ? null : $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findByCategory(int $categoryId) : array{
        $query = $this->db->prepare("SELECT * FROM posts_categories WHERE category_id = :category_id ");
        $parameters = [
            'category_id' => $categoryId
            ];
        $query->execute($parameters);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}