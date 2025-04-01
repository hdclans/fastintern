<?php
namespace App\Controllers;

class CGUController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function cgu() {
        echo $this->twig->render('cgu/cgu.twig');
    }
}
