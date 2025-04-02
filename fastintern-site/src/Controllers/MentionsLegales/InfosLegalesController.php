<?php
namespace App\Controllers\MentionsLegales;

class InfosLegalesController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function InfosLegales() {
        echo $this->twig->render('MentionsLegales/infos_legales.twig');
    }
}
