<?php
// Démarre la session en début de fichier
session_start();

// Charge l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Chargement explicite des classes qui pourraient poser problème
require_once __DIR__ . '/../src/Models/User.php';

// Définit le namespace des contrôleurs
use App\Controllers\Invite\HomeController;
use App\Controllers\Auth\ConnexionController;
use App\Controllers\Erreur404Controller;
use App\Controllers\MentionsLegales\CGUController;
use App\Controllers\MentionsLegales\PolitiqueConfidentialiteController;
use App\Controllers\MentionsLegales\InfosLegalesController;
use App\Controllers\OffreController;
use App\Database\Database;
use App\controllers\EntrepriseController; 
use App\Controllers\UploadController;
use App\Controllers\Admin\AdminOffreController;
use App\Controllers\Admin\AdminEntrepriseController;

use App\Controllers\Admin\AdminController;
use App\Controllers\Pilote\PiloteController;
use App\Controllers\Etudiant\EtudiantController;

use App\Models\OffreModel;
use App\Models\EntrepriseModel;

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

switch ($uri) {
    case 'index':
        $controller = new HomeController($twig);
        $controller->index();
        break;
    case 'offres': // Nouveau cas pour les offres
        $offreModel = new OffreModel($pdo); // Instanciation du modèle
        $controller = new OffreController($twig, $offreModel); // Instanciation du contrôleur
        $controller->index(); // Appel de la méthode pour afficher les offres
        break;
    case 'offre_detail':
        $offreModel = new \App\Models\OffreModel($pdo); // Instanciation du modèle
        $controller = new \App\Controllers\OffreController($twig, $offreModel); // Instanciation du contrôleur
        $controller->detail(); // Appel de la méthode pour afficher les détails
        break;


    case 'admin/offres':
        $controller = new \App\Controllers\AdminOffreController($twig, $pdo);
        $controller->index();
        break;
    case 'admin/offres/save':
        $controller = new \App\Controllers\AdminOffreController($twig, $pdo);
        $controller->save();
        break;
    case 'admin/offres/delete':
        $controller = new \App\Controllers\AdminOffreController($twig, $pdo);
        $controller->delete();
        break;
    case 'admin/entreprises':
        $controller = new \App\Controllers\Admin\AdminEntrepriseController($twig, $pdo);
        $controller->index();
        break;
    case 'admin/entreprises/save':
        $controller = new \App\Controllers\Admin\AdminEntrepriseController($twig, $pdo);
        $controller->save();
        break;
    case 'admin/entreprises/delete':
        $controller = new \App\Controllers\Admin\AdminEntrepriseController($twig, $pdo);
        $controller->delete();
        break;

    case 'admin/pilotes':
        $controller = new \App\Controllers\AdminPiloteController($twig, $pdo);
        $controller->index();
        break;
    case 'admin/pilotes/save':
        $controller = new \App\Controllers\AdminPiloteController($twig, $pdo);
        $controller->save();
        break;
    case 'admin/pilotes/delete':
        $controller = new \App\Controllers\AdminPiloteController($twig, $pdo);
        $controller->delete();
        break;


    case 'cgu':
        $controller = new CGUController($twig);
        $controller->cgu();
        break;
    case 'politique_confidentialite':
        $controller = new PolitiqueConfidentialiteController($twig);
        $controller->politique_confidentialite();
        break;
    case 'infos_legales':
        $controller = new InfosLegalesController($twig);
        $controller->InfosLegales();
        break;
    case 'upload_candidature':
        $controller = new \App\Controllers\UploadController($twig, $pdo); // Ajout de $pdo
        $controller->handleUpload();
        break;
    case 'connexion':
        $controller = new ConnexionController($twig);
        $controller->connexion();
        break;
    case 'addEntreprise':
        $controller->addEntreprise();
        break;
    case 'deleteEntreprise':
        $controller->deleteEntreprise();
        break;

     // Routes d'authentification
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
        $controller->forgotPassword();
        break;
    case 'entreprise':
        $entrepriseModel = new EntrepriseModel($pdo); // Instanciation du modèle Entreprise
        $controller = new EntrepriseController($twig, $entrepriseModel); // Instanciation du contrôleur
        $controller->index(); // Appel de la méthode pour afficher les entreprises
        break;


    // Espaces utilisateurs
    case 'admin':
        // Vérification des droits pour l'admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
            header('Location: ?uri=connexion');
            exit;
        }
        $controller = new AdminController($twig);
        $controller->index();
        break;
    case 'pilote':
        // Vérification des droits pour le pilote
        if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
            header('Location: ?uri=connexion');
            exit;
        }
        $controller = new PiloteController($twig);
        $controller->index();
        break;
    case 'etudiant':
        // Vérification des droits pour l'étudiant
        if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
            header('Location: ?uri=connexion');
            exit;
        }
        $controller = new EtudiantController($twig);
        $controller->index();
        break;



    default:
        $controller = new Erreur404Controller($twig);
        $controller->erreur404();
        break;
}