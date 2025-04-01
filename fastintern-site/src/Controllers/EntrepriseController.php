<?php

require_once '../vendor/autoload.php';

class EntrepriseController {
    private $twig;

    public function __construct($twig) {
        // Initialisation de Twig
        $this->twig = $twig;

    }

    public function Entreprise() {
        echo $this->twig->render('entreprise/entreprise.twig');
    }

    
}

?>
