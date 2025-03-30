<?php
namespace App\Controllers;

class Erreur404Controller {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function erreur404() {
        echo $this->twig->render('erreur404.twig');
    }
}
