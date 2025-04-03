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
    $limit = 4;  // Nombre d'entreprises par page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    if (!empty($search)) {
        $totalEntreprises = $this->entrepriseModel->countSearchEntreprises($search);
        $entreprises = $this->entrepriseModel->searchEntreprises($search, $limit, $offset);
    } else {
        $totalEntreprises = $this->entrepriseModel->countEntreprises();
        $entreprises = $this->entrepriseModel->getEntreprises($limit, $offset);
    }

    $totalPages = ceil($totalEntreprises / $limit);

    echo $this->twig->render('entreprise/entreprise.twig', [
        'entreprises' => $entreprises,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'search' => $search,
    ]);
}
         
}

?>
