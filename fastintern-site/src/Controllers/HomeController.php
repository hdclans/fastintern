<?php
namespace App\Controllers;

class HomeController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function index() {
        // Données à passer au template
        $data = [
            'title' => 'FastIntern - Accueil',
            'message' => 'Bienvenue sur FastIntern!'
        ];
        
        // Rendre le template avec les données
        echo $this->twig->render('home/index.twig', $data);
    }
}