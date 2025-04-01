<?php
// Charge l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Définit le namespace des contrôleurs
use App\Controllers\HomeController;
use App\Controllers\ConnexionController;
use App\Controllers\Erreur404Controller;
use App\Controllers\CGUController;
use App\Controllers\PolitiqueConfidentialiteController;
use App\Controllers\InfosLegalesController;

// Configuration de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../src/Views');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Désactiver le cache pendant le développement
    'debug' => true,  // Activer le mode debug
]);




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
    case 'pagination':
        $controller->pagination();
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
    case 'uploadCV':
        $controller->uploadCV();
        break;
    case 'connexion':
        $controller = new ConnexionController($twig);
        $controller->connexion();
        break;
    case 'login':
        $controller->login();
        break;
    case 'forgot-password':
        $controller->forgotPassword();
        break;
    case 'addEntreprise':
        $controller->addEntreprise();
        break;
    case 'deleteEntreprise':
        $controller->deleteEntreprise();
        break;
    default:
        $controller = new Erreur404Controller($twig);
        $controller->erreur404();
        break;
}