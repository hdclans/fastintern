<?php

namespace App\Controllers\Admin;

class AdminController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        echo $this->twig->render('Admin/index.twig');
    }
    
    // Autres méthodes pour l'administration
}