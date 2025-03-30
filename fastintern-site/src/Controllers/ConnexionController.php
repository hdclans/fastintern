<?php
namespace App\Controllers;

class ConnexionController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function connexion() {
        echo $this->twig->render('connexion/connexion.twig');
    }
}
