<?php
/**
 * Service Model
 */

require_once __DIR__ . '/../includes/db.php';

class Service {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /**
     * Get all services
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM services ORDER BY name");
        return $stmt->fetchAll();
    }

    /**
     * Get service by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}

