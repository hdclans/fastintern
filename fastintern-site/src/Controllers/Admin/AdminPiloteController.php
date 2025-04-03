<?php

namespace App\Controllers\Admin;

use Twig\Environment;
use PDO;

class AdminPiloteController
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
            $utilisateurs = $this->searchUtilisateurs($search);
        } else {
            $utilisateurs = $this->getAllUtilisateurs();
        }

        echo $this->twig->render('GestionUtilisateurs/admin_pilotes.twig', [
            'utilisateurs' => $utilisateurs,
            'search' => $search
        ]);
    }

    private function searchUtilisateurs($search)
    {
        $query = "SELECT u.*, r.nom_role 
                FROM UTILISATEUR u
                JOIN ROLE r ON u.id_role = r.id_role
                WHERE (u.nom LIKE :search OR u.prenom LIKE :search OR u.email LIKE :search)
                AND u.id_role = 2
                ORDER BY u.nom, u.prenom ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['search' => '%' . $search . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?uri=admin_pilotes');
            exit;
        }

        $id_utilisateur = $_POST['id_utilisateur'] ?? null;
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'] ?? null;
        $id_role = $_POST['id_role'];

        if ($id_utilisateur) {
            // Modification d'un utilisateur existant
            $this->updateUtilisateur($id_utilisateur, $nom, $prenom, $email, $mot_de_passe, $id_role);
        } else {
            // Création d'un nouvel utilisateur
            $this->createUtilisateur($nom, $prenom, $email, $mot_de_passe, $id_role);
        }

        header('Location: /?uri=admin_pilotes');
        exit;
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            header('Location: /?uri=admin_pilotes');
            exit;
        }

        $id = (int)$_GET['id'];
        $this->deleteUtilisateur($id);

        header('Location: /?uri=admin_pilotes');
        exit;
    }

    private function getAllUtilisateurs()
    {
        $query = "SELECT u.*, r.nom_role 
                FROM UTILISATEUR u
                JOIN ROLE r ON u.id_role = r.id_role
                WHERE u.id_role = 2
                ORDER BY u.nom, u.prenom ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function updateUtilisateur($id, $nom, $prenom, $email, $mot_de_passe, $id_role)
    {
        // Si un nouveau mot de passe est fourni, le mettre à jour
        if (!empty($mot_de_passe)) {
            $query = "UPDATE UTILISATEUR SET 
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    mot_de_passe = :mot_de_passe,
                    id_role = :id_role
                    WHERE id_utilisateur = :id_utilisateur";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'mot_de_passe' => password_hash($mot_de_passe, PASSWORD_DEFAULT),
                'id_role' => $id_role,
                'id_utilisateur' => $id
            ]);
        } else {
            // Sinon, mettre à jour sans changer le mot de passe
            $query = "UPDATE UTILISATEUR SET 
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    id_role = :id_role
                    WHERE id_utilisateur = :id_utilisateur";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'id_role' => $id_role,
                'id_utilisateur' => $id
            ]);
        }
    }

    private function createUtilisateur($nom, $prenom, $email, $mot_de_passe, $id_role)
    {
        $query = "INSERT INTO UTILISATEUR (nom, prenom, email, mot_de_passe, id_role, date_inscription) 
                VALUES (:nom, :prenom, :email, :mot_de_passe, :id_role, :date_inscription)";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mot_de_passe' => password_hash($mot_de_passe, PASSWORD_DEFAULT),
            'id_role' => $id_role,
            'date_inscription' => date('Y-m-d H:i:s')
        ]);
    }

    private function deleteUtilisateur($id)
    {
        $query = "DELETE FROM UTILISATEUR WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_utilisateur' => $id]);
    }
}