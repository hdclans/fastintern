<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Database\Database;

class ConnexionController
{
    private $twig;
    private $user;

    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->user = new User();
    }

    // Affiche la page de connexion
    public function connexion()
    {
        echo $this->twig->render('Auth/connexion.twig', [
            'error' => isset($_SESSION['error']) ? $_SESSION['error'] : null
        ]);
        
        // Nettoyer le message d'erreur après l'avoir affiché
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
    }

    // Traite le formulaire de connexion
    public function login()
    {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?uri=connexion');
            exit;
        }
        
        // Récupérer les données du formulaire
        $email = trim($_POST['email']);
        $password = $_POST['mot_de_passe']; // Doit correspondre au nom dans le formulaire
        
        // Vérifier les identifiants
        $user = $this->user->verifyLogin($email, $password);
        
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
                    header('Location: ?uri=admin');
                    break;
                case 2: // Pilote
                    header('Location: ?uri=pilote');
                    break;
                case 3: // Étudiant
                    header('Location: ?uri=etudiant');
                    break;
                default:
                    header('Location: ?uri=index');
                    break;
            }
            exit;
        } else {
            // Échec de connexion
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            header('Location: ?uri=connexion');
            exit;
        }
    }
    
    // Déconnexion
    public function logout()
    {
        // Détruire la session
        session_destroy();
        
        // Rediriger vers la page d'accueil
        header('Location: ?uri=index');
        exit;
    }
    
    // Formulaire mot de passe oublié
    public function forgotPassword()
    {
        // Ici le code pour le mot de passe oublié
        // Cette fonction est déjà dans votre switch mais non implémentée
    }
}