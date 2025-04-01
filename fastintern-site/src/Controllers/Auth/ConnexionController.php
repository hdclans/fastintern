<?php
namespace App\Controllers\Auth;

class ConnexionController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function connexion() {
        echo $this->twig->render('Auth/connexion.twig');
    }
}
