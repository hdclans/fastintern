<?php
namespace App\Models;

use PDO;

class EntrepriseModel {
    private $db;

    /**
     * Constructeur pour initialiser la connexion à la base de données
     *
     * @param PDO $db Connexion PDO à la base de données
     */
    public function __construct(PDO $db = null)
    {
        if ($db === null) {
            $database = new Database();
            $this->db = $database->getConnection();
        } else {
            $this->db = $db;
        }
    }

    /**
     * Récupérer une liste d'entreprises avec pagination
     *
     * @param int $limit Nombre d'entreprises à récupérer par page
     * @param int $offset Nombre d'entreprises à ignorer (pour la pagination)
     * @return array Liste des entreprises
     */
    public function getEntreprises($limit = 4, $offset = 0) {
        $sql = "
            SELECT  
                description, 
                email_contact, 
                telephone_contact, 
                adresse, 
                date_creation,
                date_modification,
                nom_entreprise 
            FROM ENTREPRISE
            LIMIT :limit OFFSET :offset
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retourne toutes les entreprises
    }
    
    public function countEntreprises() {
        $sql = "SELECT COUNT(*) as total FROM ENTREPRISE";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
}