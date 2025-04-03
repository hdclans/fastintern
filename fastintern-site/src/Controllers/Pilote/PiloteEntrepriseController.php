<?php

namespace App\Controllers\Pilote;

use Twig\Environment;
use PDO;

class PiloteEntrepriseController
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
        $search = $_GET['search'] ?? null;

        if ($search) {
            $entreprises = $this->searchEntreprises($search);
        } else {
            $entreprises = $this->getAllEntreprises();
        }

        echo $this->twig->render('entreprise/entreprise_pilote.twig', [
            'entreprises' => $entreprises,
            'search' => $search
        ]);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?uri=pilote_entreprises');
            exit;
        }

        $id_entreprise = $_POST['id_entreprise'] ?? null;

        $data = [
            'nom_entreprise' => $_POST['nom_entreprise'],
            'description' => $_POST['description'] ?? null,
            'email_contact' => $_POST['email_contact'],
            'telephone_contact' => $_POST['telephone_contact'] ?? null,
            'adresse' => $_POST['adresse'] ?? null,
        ];

        if ($id_entreprise) {
            // Modification
            $this->updateEntreprise($id_entreprise, $data);
        } else {
            // Création
            $data['id_utilisateur'] = $_SESSION['user_id'] ?? null;
            $this->createEntreprise($data);
        }

        header('Location: /?uri=pilote_entreprises');
        exit;
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            header('Location: /?uri=pilote_entreprises');
            exit;
        }

        $id = (int)$_GET['id'];
        $this->deleteEntreprise($id);

        header('Location: /?uri=pilote_entreprises');
        exit;
    }

    private function getAllEntreprises()
    {
        $query = "SELECT id_entreprise, nom_entreprise, description, email_contact, 
                         telephone_contact, adresse, date_creation, date_modification 
                  FROM ENTREPRISE 
                  ORDER BY nom_entreprise ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function searchEntreprises($search)
    {
        $query = "SELECT * FROM ENTREPRISE WHERE nom_entreprise LIKE :search ORDER BY nom_entreprise ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['search' => '%' . $search . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function updateEntreprise($id, $data)
    {
        $query = "UPDATE ENTREPRISE SET 
                  nom_entreprise = :nom_entreprise,
                  description = :description,
                  email_contact = :email_contact,
                  telephone_contact = :telephone_contact,
                  adresse = :adresse,
                  date_modification = NOW()
                  WHERE id_entreprise = :id_entreprise";
        $stmt = $this->pdo->prepare($query);
        $data['id_entreprise'] = $id;
        $stmt->execute($data);
    }

    private function createEntreprise($data)
    {
        $query = "INSERT INTO ENTREPRISE (nom_entreprise, description, email_contact, 
                                        telephone_contact, adresse, date_creation, id_utilisateur) 
                VALUES (:nom_entreprise, :description, :email_contact, 
                        :telephone_contact, :adresse, NOW(), :id_utilisateur)";
        $stmt = $this->pdo->prepare($query);

        // Ajoutez des valeurs par défaut pour les champs manquants
        $data = array_merge([
            'description' => null,
            'telephone_contact' => null,
            'adresse' => null,
            'id_utilisateur' => null,
        ], $data);

        $stmt->execute($data);
    }

    private function deleteEntreprise($id)
    {
        $query = "DELETE FROM ENTREPRISE WHERE id_entreprise = :id_entreprise";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_entreprise' => $id]);
    }
}
