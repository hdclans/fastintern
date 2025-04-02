<?php

namespace App\Controllers\Pilote;

class PiloteController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        echo $this->twig->render('Pilote/index.twig');
    }
    
    // Autres méthodes pour les pilotes
}