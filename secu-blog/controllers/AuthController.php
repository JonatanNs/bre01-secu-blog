<?php

class AuthController extends AbstractController
{
    public function login() : void {
        $this->render("login", []);
    }

    public function checkLogin() : void {
        if(isset($_POST['login-submit'])){


            if(isset($_SESSION['csrf_token']) && isset($_POST['csrf-token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf-token'])) {
                unset($_SESSION['csrf_token']);
            }else {
                $this->redirect("index.php?route=login");
            }
            
                if(isset($_POST['email'], $_POST['password'])){
                    // Récupérer les données postées et les nettoyer
                    $email = htmlspecialchars($_POST['email']);
                    $password = htmlspecialchars($_POST['password']);
                    
                    $userManager = new UserManager();
                    $userData = $userManager->findByEmail($email);
                    
                    if($userData !== null && password_verify($password, $userData['password'])){
                        $this->redirect("index.php?route=home");
                        $_SESSION['connexion'] = "Vous etes connecter";
                    } else {
                        $_SESSION['error'] = "Email ou mot de passe incorrect.";
                        $this->redirect("index.php?route=login");
                    }
                } else {
                    $_SESSION['error'] = "Veuillez saisir votre email et votre mot de passe.";
                    $this->redirect("index.php?route=login");
                }
            } else {
            // Redirection vers la page de connexion si le formulaire n'a pas été soumis
            $this->redirect("index.php?route=login");
            }
        
    }

    public function register() : void {
        $this->render("register", []);
    }

    public function checkRegister() : void {
        
        if(isset($_POST['register-submit'])) {
            
            if(isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm-password'])) {
            
                    $password = $_POST['password'];
                    $confirmPassword = $_POST['confirm-password'];
                    // Vérifier si le mot de passe respecte les critères
                    if(preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/', $password)){
                        // Mot de passe valide
                        if($_POST['password'] === $_POST['confirm-password']) {
                    
                                $username = htmlspecialchars($_POST['username']);
                                $email = htmlspecialchars($_POST['email']);
                                $password = htmlspecialchars($_POST['password']);
                                // Hasher le mot de passe
                                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                // Créer une instance de UserManager
                                $userManager = new UserManager();
                                // Créer un nouvel utilisateur
                                $user = new User($username, $email, $hashedPassword, "USER", $_POST['dateTime']);
                                $userManager->create($user);
                                //formulaire remplie chek reussie direction login
                                $this->redirect("index.php?route=login");
                        } else {
                            $this->redirect("index.php?route=register");
                            $_SESSION['error'] = "Votre mot de passe et Confirm password sont différents.";
                                }
                            
                    } else {
                        // Mot de passe invalide
                        $this->redirect("index.php?route=register");
                        $_SESSION['errorRegister'] = "es mots de passe doivent faire 8 caractères au minimum, avec au moins une majuscule, 
                            une minuscule, un chiffre et un caractère spécial.";
                    }
            }  else {
                $this->redirect("index.php?route=register");
                $_SESSION['errorRegister'] = "Veuillez remplir tous les champs du formulaire.";
            }
    
        }
        
    }
    
    public function logout() : void {
        session_destroy();

        $this->redirect("index.php");
    }
}