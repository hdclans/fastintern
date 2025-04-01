<?php

namespace App\Controllers\Etudiant;

class EtudiantController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        echo $this->twig->render('Etudiant/index.twig');
    }
    
    // Autres méthodes pour les étudiants
}