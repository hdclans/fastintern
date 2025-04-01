<?php
namespace App\Controllers;

class PolitiqueConfidentialiteController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function politique_confidentialite() {
        echo $this->twig->render('politique_confidentialite/politique_confidentialite.twig');
    }
}
