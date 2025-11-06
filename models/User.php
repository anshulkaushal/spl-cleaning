<?php
/**
 * User Model
 */

require_once __DIR__ . '/../includes/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /**
     * Create a new user
     */
    public function create($name, $email, $phone, $address, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, phone, address, password_hash) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([$name, $email, $phone, $address, $passwordHash]);
    }

    /**
     * Find user by email
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Find user by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT id, name, email, phone, address, created_at FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Verify password
     */
    public function verifyPassword($email, $password) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return false;
    }

    /**
     * Check if email exists
     */
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
}

