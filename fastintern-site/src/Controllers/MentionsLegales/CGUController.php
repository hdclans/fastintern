<?php
namespace App\Controllers\MentionsLegales;

class CGUController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function cgu() {
        echo $this->twig->render('MentionsLegales/cgu.twig');
    }
}
