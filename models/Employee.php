<?php
/**
 * Employee Model
 */

require_once __DIR__ . '/../includes/db.php';

class Employee {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /**
     * Get all employees
     */
    public function getAll($activeOnly = false) {
        $sql = "SELECT * FROM employees";
        if ($activeOnly) {
            $sql .= " WHERE active_status = 1";
        }
        $sql .= " ORDER BY name";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get employee by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM employees WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Create employee
     */
    public function create($name, $email, $phone, $role = 'Cleaner') {
        $stmt = $this->db->prepare("
            INSERT INTO employees (name, email, phone, role) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $email, $phone, $role]);
    }

    /**
     * Update employee
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $id;
        $sql = "UPDATE employees SET " . implode(', ', $fields) . " WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Delete employee
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM employees WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

