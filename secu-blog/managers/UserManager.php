<?php

class UserManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }
    
    public function findByEmail(string $email) : ?array {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $parameters = [
            'email' => $email
        ];
        $query->execute($parameters);
        
        // Vérifier si des résultats ont été retournés
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user === false) {
            // Aucun utilisateur trouvé avec cet email, renvoyer null
            return null;
        }
        
        // Utilisateur trouvé, renvoyer les données de l'utilisateur
        return $user;
    }

    
    public function create(User $user) : void {
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $query = $this->db->prepare("INSERT INTO users (username, email, password, role, created_at) 
                                        VALUES(:username, :email, :password, :role, :created_at)");
        $query->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
            'created_at' => $user->getCreated_at(),
        ]);
    }
}