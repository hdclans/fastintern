<?php
namespace App\Controllers\MentionsLegales;

class PolitiqueConfidentialiteController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function politique_confidentialite() {
        echo $this->twig->render('MentionsLegales/politique_confidentialite.twig');
    }
}
