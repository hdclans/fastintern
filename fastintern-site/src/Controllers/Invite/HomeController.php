<?php
namespace App\Controllers\Invite;

class HomeController {
    private $twig;
    
    public function __construct($twig) {
        $this->twig = $twig;
    }
    
    public function index() {
        echo $this->twig->render('Invite/index.twig');
    }

}
