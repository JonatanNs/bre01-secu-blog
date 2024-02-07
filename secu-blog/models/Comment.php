<?php

class Comment{
    private ? int $id = null;
    
    public function __construct(private string $content, private int $user_id, private int $post_id){
        
    }
    
    public function getId() : ? int{
        return $this->id;
    }
    public function setId(? int $id) : void{
        $this->id = $id;
    }
    
    public function getContent() : string{
        return $this->content;
    }
    public function setContent(string $content) : void{
        $this->content = $content;
    }
    
    public function getUser_id() : int{
        return $this->user_id;
    }
    public function setUser_id(int $user_id) : void{
        $this->user_id = $user_id;
    }
    
    public function getPost_id() :  int{
        return $this->post_id;
    }
    public function setPost_id( int $post_id) : void{
        $this->post_id = $post_id;
    }
}