<?php

class CommentManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }
    
    public function findByPost(int $postId) : array {
        $query = $this->db->prepare("SELECT * FROM comments WHERE post_id = :post_id");
        $parameters = [
            'post_id' => $postId
            ];
        $query->execute($parameters);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create(Comment $comment) : void {
        $query = $this->db->prepare("INSERT INTO messages (id, content, user_id, post_id) 
                                        VALUES(null, :content, :user_id, :post_id)");
        $parameters = [
            'content' => $comment, 
            'user_id' => $userId /* $comment['$userId']*/, 
            'post_id' => $postId /* $comment['$postId']*/
            ];
        $query->execute($parameters);
        
    }
    
}