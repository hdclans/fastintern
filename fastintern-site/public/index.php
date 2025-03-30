<?php
// Charge l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Définit le namespace des contrôleurs
use App\Controllers\HomeController;
use App\Controllers\ConnexionController;

// Configuration de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../src/Views');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Désactiver le cache pendant le développement
    'debug' => true,  // Activer le mode debug
]);

// Routage simple
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Gestion des routes
switch ($path) {
    case '/':
    case '/index':
        $controller = new HomeController($twig);
        $controller->index();
        break;
    case '/connexion':
        $controller = new ConnexionController($twig);
        $controller->connexion();
        break;
    default:
        // Page 404
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page non trouvée";
        break;
}