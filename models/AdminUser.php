<?php
/**
 * Admin User Model
 */

require_once __DIR__ . '/../includes/db.php';

class AdminUser {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /**
     * Find admin by email
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM admin_users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Verify password
     */
    public function verifyPassword($email, $password) {
        $admin = $this->findByEmail($email);
        if ($admin && password_verify($password, $admin['password_hash'])) {
            return $admin;
        }
        return false;
    }
}

