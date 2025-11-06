<?php
/**
 * CV Application Model
 */

require_once __DIR__ . '/../includes/db.php';

class CVApplication {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /**
     * Create a new CV application
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO cv_applications (
                full_name, email, phone, position, experience_years, 
                experience_text, preferred_work_type, cv_filename, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['position'],
            $data['experience_years'] ?? null,
            $data['experience_text'] ?? null,
            $data['preferred_work_type'],
            $data['cv_filename'],
            $data['status'] ?? 'New'
        ]);
    }

    /**
     * Get all CV applications
     */
    public function getAll($filters = []) {
        $sql = "SELECT * FROM cv_applications WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['position'])) {
            $sql .= " AND position = ?";
            $params[] = $filters['position'];
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Get CV application by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM cv_applications WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Update CV application
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $id;
        $sql = "UPDATE cv_applications SET " . implode(', ', $fields) . " WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Get total count
     */
    public function getTotalCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM cv_applications");
        return $stmt->fetchColumn();
    }
}

