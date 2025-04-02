<?php
class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /');
            exit;
        }
        
        // Récupérer les données du formulaire
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        
        // Vérifier les identifiants
        $user = $this->userModel->verifyLogin($email, $password);
        
        if ($user) {
            // Connexion réussie - créer session
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['role_id'] = $user['id_role'];
            
            // Rediriger selon le rôle
            switch ($user['id_role']) {
                case 1: // Admin
                    header('Location: /admin');
                    break;
                case 2: // Pilote
                    header('Location: /pilote');
                    break;
                case 3: // Étudiant
                    header('Location: /etudiant');
                    break;
                default:
                    header('Location: /');
                    break;
            }
            exit;
        } else {
            // Échec de connexion
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            header('Location: /');
            exit;
        }
    }
}
?>