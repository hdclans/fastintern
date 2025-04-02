<?php
// filepath: c:\xampp\htdocs\fastintern1\fastintern\fastintern-site\src\Models\OffreModel.php

namespace App\Models;

use PDO;
use App\Database\Database;

class OffreModel
{
    private $db;

    public function __construct(PDO $db = null)
    {
        if ($db === null) {
            $database = new Database();
            $this->db = $database->getConnection();
        } else {
            $this->db = $db;
        }
    }

    public function getPaginatedOffers($limit, $offset)
{
    $query = "
        SELECT 
            o.id_offre,
            o.titre,
            o.description,
            o.remuneration,
            o.date_debut,
            o.date_fin,
            o.date_publication,
            e.nom_entreprise
        FROM OFFRE_STAGE o
        INNER JOIN ENTREPRISE e ON o.id_entreprise = e.id_entreprise
        LIMIT :limit OFFSET :offset
    ";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getTotalOffersCount()
    {
        $query = "SELECT COUNT(*) as total FROM OFFRE_STAGE";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'];
    }

    public function getOfferById($idOffre)
    {
        $query = "
            SELECT 
                o.id_offre,
                o.titre,
                o.description,
                o.remuneration,
                o.date_debut,
                o.date_fin,
                o.date_publication,
                e.nom_entreprise,
                e.adresse
            FROM OFFRE_STAGE o
            INNER JOIN ENTREPRISE e ON o.id_entreprise = e.id_entreprise
            WHERE o.id_offre = :id_offre
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_offre', $idOffre, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}