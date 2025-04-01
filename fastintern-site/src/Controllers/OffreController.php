<?php

namespace App\Controllers;

use App\Models\OffreModel;
use App\Database\Database;
use Twig\Environment;

class OffreController
{
    private $offreModel;
    private $twig;

    public function __construct(Environment $twig, OffreModel $offreModel = null)
    {
        $this->twig = $twig;
        
        if ($offreModel === null) {
            $database = new Database();
            $pdo = $database->getConnection();
            $this->offreModel = new OffreModel($pdo);
        } else {
            $this->offreModel = $offreModel;
        }
    }

    public function index()
    {
        // Pagination parameters
        $limit = 9; // Nombre d'offres par page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Obtenir le nombre total d'offres
        $totalOffers = $this->offreModel->getTotalOffersCount();
        $totalPages = ceil($totalOffers / $limit);

        // Vérification : rediriger si la page est invalide
        if ($page < 1 || $page > $totalPages) {
            header('Location: /?uri=offres&page=1');
            exit;
        }

        $offset = ($page - 1) * $limit;

        // Fetch data
        $offres = $this->offreModel->getPaginatedOffers($limit, $offset);

        // Calculate pagination
        $pagination = [
            'current' => $page,
            'previous' => $page > 1 ? $page - 1 : null,
            'next' => $page < $totalPages ? $page + 1 : null,
            'pages' => range(1, $totalPages),
        ];

        // Render view with Twig
        echo $this->twig->render('offre/offre_etudiant.twig', [
            'offres' => $offres,
            'pagination' => $pagination,
        ]);
    }
}