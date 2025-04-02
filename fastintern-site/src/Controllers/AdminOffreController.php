<?php

namespace App\Controllers;

use Twig\Environment;
use PDO;

class AdminOffreController
{
    private $twig;
    private $pdo;

    public function __construct(Environment $twig, PDO $pdo)
    {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    public function index()
    {
        $offres = $this->getAllOffres();
        $entreprises = $this->getAllEntreprises();

        echo $this->twig->render('offre/offre_admin.twig', [
            'offres' => $offres,
            'entreprises' => $entreprises
        ]);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?uri=admin/offres');
            exit;
        }

        $id_offre = $_POST['id_offre'] ?? null;
        $data = [
            'titre' => $_POST['titre'],
            'description' => $_POST['description'],
            'remuneration' => $_POST['remuneration'],
            'date_debut' => $_POST['date_debut'],
            'date_fin' => $_POST['date_fin'],
            'id_entreprise' => $_POST['id_entreprise'],
            'date_modification' => date('Y-m-d H:i:s')
        ];

        if ($id_offre) {
            // Modification
            $this->updateOffre($id_offre, $data);
        } else {
            // Création
            $data['date_publication'] = date('Y-m-d H:i:s');
            $data['id_statut_offre'] = 1;
            $this->createOffre($data);
        }

        header('Location: /?uri=admin/offres');
        exit;
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            header('Location: /?uri=admin/offres');
            exit;
        }

        $id = (int)$_GET['id'];
        $this->deleteOffre($id);

        header('Location: /?uri=admin/offres');
        exit;
    }

    private function getAllOffres()
    {
        $query = "SELECT o.*, e.nom_entreprise, s.statut as statut 
                FROM OFFRE_STAGE o 
                JOIN ENTREPRISE e ON o.id_entreprise = e.id_entreprise
                JOIN STATUT_OFFRE s ON o.id_statut_offre = s.id_statut_offre
                ORDER BY o.date_publication DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getAllEntreprises()
    {
        $query = "SELECT id_entreprise, nom_entreprise FROM ENTREPRISE ORDER BY nom_entreprise";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function updateOffre($id, $data)
    {
        $query = "UPDATE OFFRE_STAGE SET 
                 titre = :titre,
                 description = :description,
                 remuneration = :remuneration,
                 date_debut = :date_debut,
                 date_fin = :date_fin,
                 id_entreprise = :id_entreprise,
                 date_modification = :date_modification
                 WHERE id_offre = :id_offre";
        
        $stmt = $this->pdo->prepare($query);
        $data['id_offre'] = $id;
        $stmt->execute($data);
    }

    private function createOffre($data)
    {
        $query = "INSERT INTO OFFRE_STAGE 
                 (titre, description, remuneration, date_debut, date_fin, 
                  date_publication, date_modification, id_statut_offre, id_entreprise)
                 VALUES 
                 (:titre, :description, :remuneration, :date_debut, :date_fin,
                  :date_publication, :date_modification, :id_statut_offre, :id_entreprise)";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
    }

    private function deleteOffre($id)
    {
        $query = "DELETE FROM OFFRE_STAGE WHERE id_offre = :id_offre";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_offre' => $id]);
    }
}