<?php
namespace App\Controllers;

use App\Models\EntrepriseModel;
use Twig\Environment;

class EntrepriseController {
    private $twig;
    private $entrepriseModel;

    /**
     * Constructeur pour initialiser Twig et le modèle des entreprises
     *
     * @param Environment $twig Instance de Twig pour le rendu des templates
     * @param EntrepriseModel $entrepriseModel Instance du modèle EntrepriseModel
     */
    public function __construct(Environment $twig, EntrepriseModel $entrepriseModel) {
        $this->twig = $twig;
        $this->entrepriseModel = $entrepriseModel;
    }

    /**
     * Affiche la liste des entreprises avec pagination
     */
    public function index() {
        // Récupérer le numéro de page à partir des paramètres GET (par défaut, page 1)
        $limit = 4;  // Nombre d'entreprises par page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Calcul du numéro de page (par défaut, 1)
        $offset = ($page - 1) * $limit;  // Calcul du décalage pour la requête SQL

        // Récupérer les entreprises et le nombre total d'entreprises
        $totalEntreprises = $this->entrepriseModel->countEntreprises();
        $totalPages = ceil($totalEntreprises / $limit);  // Calcul du nombre total de pages
        $entreprises = $this->entrepriseModel->getEntreprises($limit, $offset);

        $pagination = [
            'current' => $page,
            'previous' => $page > 1 ? $page - 1 : null,
            'next' => $page < $totalPages ? $page + 1 : null,
            'pages' => range(1, $totalPages),
        ];

        // Rendu de la vue avec Twig
        echo $this->twig->render('entreprise/entreprise.twig', [
            'entreprises' => $entreprises,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
       
    }
    
}
