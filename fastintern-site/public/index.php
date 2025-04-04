<?php
// Démarre la session en début de fichier
session_start();    

// Charge l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Chargement explicite des classes qui pourraient poser problème
require_once __DIR__ . '/../src/Models/User.php';

// Définit le namespace des contrôleurs
use App\Controllers\Erreur404Controller;
use App\Controllers\OffreController;
use App\Controllers\EntrepriseController; 
use App\Controllers\UploadController;

use App\Database\Database;

use App\Controllers\Invite\HomeController;
use App\Controllers\Auth\ConnexionController;
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\AdminOffreController;
use App\Controllers\Admin\AdminEntrepriseController;
use App\Controllers\Admin\AdminEtudiantController;
use App\Controllers\Admin\AdminPiloteController;
use App\Controllers\Pilote\PiloteController;
use App\Controllers\Pilote\PiloteOffreController;
use App\Controllers\Pilote\PiloteEntrepriseController;
use App\Controllers\Pilote\PiloteEtudiantController;
use App\Controllers\Etudiant\EtudiantOffreController;
use App\Controllers\Etudiant\EtudiantController;

use App\Models\OffreModel;

// Configuration de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../src/Views');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Désactiver le cache pendant le développement
    'debug' => true,  // Activer le mode debug
]);

// Connexion à la base de données
$database = new Database();
$pdo = $database->getConnection();

// Ajouter les variables de session à Twig
$twig->addGlobal('session', $_SESSION);

// Récupère l'URL demandée
if (isset($_GET['uri'])) {
    $uri = $_GET['uri'];
} else {
    $uri = 'index';
}

// Liste des routes publiques (accessibles sans connexion)
$public_routes = ['index', 'connexion', 'login', 'forgot-password'];

// Vérifier si l'utilisateur est connecté pour les routes protégées
if (!isset($_SESSION['user_id']) && !in_array($uri, $public_routes)) {
    // Rediriger vers la page de connexion si non connecté
    header('Location: ?uri=connexion');
    exit;
}

// Définir les routes autorisées par rôle
$role_routes = [
    1 => ['admin', 'admin_profil', 'logout', 
          'admin_offres', 'admin_offres_save', 'admin_offres_delete',
          'admin_entreprises', 'admin_entreprises_save', 'admin_entreprises_delete',
          'admin_etudiants', 'admin_etudiants_save', 'admin_etudiants_delete',
          'admin_pilotes', 'admin_pilotes_save', 'admin_pilotes_delete'], // Admin
    2 => ['pilote', 'pilote_profil', 'logout', 
          'pilote_offres', 'pilote_offres_save', 'pilote_offres_delete',
          'pilote_entreprises', 'pilote_entreprises_save', 'pilote_entreprises_delete',
          'pilote_etudiants', 'pilote_etudiants_save', 'pilote_etudiants_delete',], // Pilote
    3 => ['etudiant', 'etudiant_profil', 'logout', 'offres', 'detail', 'entreprise'],
];

// Si l'utilisateur est connecté, vérifier s'il a accès à la route demandée
if (isset($_SESSION['user_id']) && !in_array($uri, $public_routes)) {
    $role_id = $_SESSION['role_id'];
    
    // Si la route n'est pas autorisée pour ce rôle et n'est pas une route publique
    if (!in_array($uri, $role_routes[$role_id])) {
        // Rediriger vers sa page d'accueil selon son rôle
        switch ($role_id) {
            case 1:
                header('Location: ?uri=admin');
                break;
            case 2:
                header('Location: ?uri=pilote');
                break;
            case 3:
                header('Location: ?uri=etudiant');
                break;
            default:
                header('Location: ?uri=index');
                break;
        }
        exit;
    }
}

switch ($uri) {
    case 'index':
        $controller = new HomeController($twig);
        $controller->index();
        break;
        
    case 'connexion':
        $controller = new ConnexionController($twig);
        $controller->connexion();
        break;
        
    case 'login':
        $controller = new ConnexionController($twig);
        $controller->login();
        break;
        
    case 'logout':
        $controller = new ConnexionController($twig);
        $controller->logout();
        break;
        
    case 'forgot-password':
        $controller = new ConnexionController($twig);
        $controller->forgotPassword();
        break;




    // Routes de l'admin
    case 'admin':
        $controller = new AdminController($twig);
        $controller->index();
        break;
        
    case 'admin_profil':
        $controller = new AdminController($twig);
        $controller->profil();
        break;

    case 'admin_offres':
        $controller = new AdminOffreController($twig, $pdo);
        $controller->offres();
        break;

    case 'admin_offres_save':
        $controller = new AdminOffreController($twig, $pdo);
        $controller->save();
        break;
    case 'admin_offres_delete':
        $controller = new AdminOffreController($twig, $pdo);
        $controller->delete();
        break;
        
    case 'admin_entreprises':
        $controller = new AdminEntrepriseController($twig, $pdo);
        $controller->index();
        break;
    
    case 'admin_entreprises_save':
        $controller = new AdminEntrepriseController($twig, $pdo);
        $controller->save();
        break;
    
    case 'admin_entreprises_delete':
        $controller = new AdminEntrepriseController($twig, $pdo);
        $controller->delete();
        break;
    
    case 'admin_etudiants':
        $controller = new AdminEtudiantController($twig, $pdo);
        $controller->index();
        break;
        
    case 'admin_etudiants_save':
        $controller = new AdminEtudiantController($twig, $pdo);
        $controller->save();
        break;
    
    case 'admin_etudiants_delete':
        $controller = new AdminEtudiantController($twig, $pdo);
        $controller->delete();
        break;
    
    case 'admin_pilotes':
        $controller = new AdminPiloteController($twig, $pdo);
        $controller->index();
        break;
    
    case 'admin_pilotes_save':
        $controller = new AdminPiloteController($twig, $pdo);
        $controller->save();
        break;
    
    case 'admin_pilotes_delete':
        $controller = new AdminPiloteController($twig, $pdo);
        $controller->delete();
        break;





    // Routes du pilote
    case 'pilote':
        $controller = new PiloteController($twig);
        $controller->index();
        break;
        
    case 'pilote_profil':
        $controller = new PiloteController($twig);
        $controller->profil();
        break;
    
    case 'pilote_offres':
        $controller = new PiloteOffreController($twig, $pdo);
        $controller->offres();
        break;

    case 'pilote_offres_save':
        $controller = new PiloteOffreController($twig, $pdo);
        $controller->save();
        break;
    case 'pilote_offres_delete':
        $controller = new PiloteOffreController($twig, $pdo);
        $controller->delete();
        break;
        
    case 'pilote_entreprises':
        $controller = new \App\Controllers\pilote\PiloteEntrepriseController($twig, $pdo);
        $controller->index();
        break;
    
    case 'pilote_entreprises_save':
        $controller = new \App\Controllers\pilote\PiloteEntrepriseController($twig, $pdo);
        $controller->save();
        break;
    
    case 'pilote_entreprises_delete':
        $controller = new \App\Controllers\pilote\PiloteEntrepriseController($twig, $pdo);
        $controller->delete();
        break;
    
    case 'pilote_etudiants':
        $controller = new PiloteEtudiantController($twig, $pdo);
        $controller->index();
        break;
        
    case 'pilote_etudiants_save':
        $controller = new PiloteEtudiantController($twig, $pdo);
        $controller->save();
        break;
    
    case 'pilote_etudiants_delete':
        $controller = new PiloteEtudiantController($twig, $pdo);
        $controller->delete();
        break;
    
    case 'pilote_pilotes':
        $controller = new PilotePiloteController($twig, $pdo);
        $controller->index();
        break;
    
    case 'pilote_pilotes_save':
        $controller = new PilotePiloteController($twig, $pdo);
        $controller->save();
        break;
    
    case 'pilote_pilotes_delete':
        $controller = new PilotePiloteController($twig, $pdo);
        $controller->delete();
        break;    
        




        
    // Routes de l'étudiant
    case 'etudiant':
        $controller = new EtudiantController($twig);
        $controller->index();
        break;
        
    case 'etudiant_profil':
        $controller = new EtudiantController($twig);
        $controller->profil();
        break;

    case 'offres':
        $offreModel = new OffreModel($pdo); // Instanciation du modèle
        $controller = new EtudiantOffreController($twig, $offreModel);
        $controller->index();
        break;

    case 'detail':
        $offreModel = new OffreModel($pdo); // Instanciation du modèle
        $controller = new EtudiantOffreController($twig, $offreModel); // Instanciation du contrôleur
        $controller->detail(); // Appel de la méthode pour afficher les détails
        break;   

    case 'entreprise':
        $entrepriseModel = new \App\Models\EntrepriseModel($pdo);
        $controller = new EntrepriseController($twig, $entrepriseModel);
        $controller->index();
        break;


    default:
        $controller = new Erreur404Controller($twig);
        $controller->erreur404();
        break;
}