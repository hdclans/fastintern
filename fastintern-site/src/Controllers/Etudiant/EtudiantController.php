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
    
    public function profil()
    {
        echo $this->twig->render('Etudiant/profil.twig');
    }
}