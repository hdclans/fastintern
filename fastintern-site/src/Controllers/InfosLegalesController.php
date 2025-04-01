<?php
namespace App\Controllers;

class InfosLegalesController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function InfosLegales() {
        echo $this->twig->render('infos_legales/infos_legales.twig');
    }
}
