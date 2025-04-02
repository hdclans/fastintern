<?php

namespace App\Models;

use App\Database\Database;

class User
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    /**
     * Vérifie les identifiants de connexion
     * 
     * @param string $email
     * @param string $password
     * @return array|false Les données de l'utilisateur si valide, false sinon
     */
    public function verifyLogin($email, $password)
    {
        try {
            $conn = $this->db->getConnection();
            
            // Requête pour trouver l'utilisateur par email
            $stmt = $conn->prepare("SELECT * FROM UTILISATEUR WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                
                // Vérifier le mot de passe
                // Si vos mots de passe sont en clair dans la base
                if ($password == $user['mot_de_passe']) {
                    return $user;
                }
                
                // OU si vos mots de passe sont hashés avec password_hash()
                // if (password_verify($password, $user['mot_de_passe'])) {
                //     return $user;
                // }
            }
            
            return false;
        } catch(\PDOException $e) {
            error_log("Erreur de connexion : " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Trouve un utilisateur par son ID
     * 
     * @param int $id
     * @return array|false L'utilisateur trouvé ou false si aucun
     */
    public function findById($id)
    {
        try {
            $stmt = $this->db->getConnection()->prepare(
                "SELECT * FROM UTILISATEUR WHERE id_utilisateur = :id"
            );
            
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            error_log("Erreur dans findById : " . $e->getMessage());
            return false;
        }
    }
}