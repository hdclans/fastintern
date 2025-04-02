<?php

namespace App\Controllers;

use Twig\Environment;
use PDO;

class UploadController
{
    private $twig;
    private $pdo;
    private $maxFileSize = 2097152; // 2Mo en bytes
    private $uploadDir;

    public function __construct(Environment $twig, PDO $pdo)
    {
        $this->twig = $twig;
        $this->pdo = $pdo;
        $this->uploadDir = __DIR__ . '/../../uploads/';
        
        // Création du dossier uploads s'il n'existe pas
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function handleUpload()
    {
        // Vérification de la connexion utilisateur
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vous devez être connecté pour postuler.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Récupération des informations nécessaires
        $userId = $_SESSION['user_id'];
        $offreId = $_POST['offre_id'];

        // Récupérer les informations de l'utilisateur
        $userInfo = $this->getUserInfo($userId);
        if (!$userInfo) {
            $_SESSION['error'] = 'Impossible de récupérer les informations de l\'utilisateur.';
            header('Location: /?uri=offres');
            exit;
        }

        // Validation des fichiers
        if (!$this->validateFiles()) {
            header('Location: /?uri=offre_detail&id=' . $offreId);
            exit;
        }

        // Création du chemin de destination
        $userDir = $this->createUserDirectory($userId, $userInfo['nom'], $userInfo['prenom']);
        $offreDir = $this->createOffreDirectory($userDir, $offreId);

        // Upload des fichiers
        if ($this->uploadFiles($offreDir)) {
            $_SESSION['success'] = 'Votre candidature a été envoyée avec succès.';
        } else {
            $_SESSION['error'] = 'Une erreur est survenue lors de l\'envoi de votre candidature.';
        }

        header('Location: /?uri=offre_detail&id=' . $offreId);
        exit;
    }

    private function getUserInfo($userId)
    {
        $query = "SELECT nom, prenom FROM UTILISATEUR WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_utilisateur', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function validateFiles()
    {
        $files = ['cv', 'lettre'];
        foreach ($files as $file) {
            if (!isset($_FILES[$file]) || $_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Erreur lors de l'upload du fichier $file.";
                return false;
            }

            if ($_FILES[$file]['size'] > $this->maxFileSize) {
                $_SESSION['error'] = "Le fichier $file dépasse la taille maximale autorisée (2Mo).";
                return false;
            }

            $mimeType = mime_content_type($_FILES[$file]['tmp_name']);
            if ($mimeType !== 'application/pdf') {
                $_SESSION['error'] = "Le fichier $file doit être au format PDF.";
                return false;
            }
        }
        return true;
    }

    private function createUserDirectory($userId, $nom, $prenom)
    {
        $userDir = $this->uploadDir . 'upload.' . $userId . '.' . $this->cleanString($nom) . '.' . $this->cleanString($prenom) . '/';
        if (!file_exists($userDir)) {
            mkdir($userDir, 0777, true);
        }
        return $userDir;
    }

    private function createOffreDirectory($userDir, $offreId)
    {
        // Récupérer les informations de l'offre et de l'entreprise depuis la base de données
        $offreInfo = $this->getOffreInfo($offreId);
        if (!$offreInfo) {
            return false;
        }

        $date = date('Y-m-d');
        $offreDir = $userDir . $this->cleanString($offreInfo['nom_entreprise']) . '.' . 
                   $this->cleanString($offreInfo['titre']) . '.' . $date . '/';
        
        if (!file_exists($offreDir)) {
            mkdir($offreDir, 0777, true);
        }
        return $offreDir;
    }

    private function getOffreInfo($offreId)
    {
        $query = "SELECT titre, nom_entreprise FROM OFFRE_STAGE o
                  INNER JOIN ENTREPRISE e ON o.id_entreprise = e.id_entreprise
                  WHERE o.id_offre = :id_offre";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_offre', $offreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function uploadFiles($destination)
    {
        $files = [
            'cv' => 'cv.pdf',
            'lettre' => 'lettre_motivation.pdf'
        ];

        foreach ($files as $input => $filename) {
            $tmpFile = $_FILES[$input]['tmp_name'];
            if (!move_uploaded_file($tmpFile, $destination . $filename)) {
                return false;
            }
        }
        return true;
    }

    private function cleanString($string)
    {
        $string = preg_replace('/[^a-zA-Z0-9]+/', '_', $string);
        $string = strtolower(trim($string, '_'));
        return $string;
    }
}