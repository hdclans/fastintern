<?php
// filepath: c:\xampp\htdocs\fastintern1\fastintern\fastintern-site\src\Models\OffreModel.php

namespace App\Models;

use PDO;

class OffreModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getPaginatedOffers($limit, $offset)
{
    $query = "
        SELECT 
            id_offre, 
            titre, 
            description, 
            remuneration, 
            date_debut, 
            date_fin, 
            date_publication 
        FROM OFFRE_STAGE 
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
}