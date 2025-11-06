<?php
/**
 * Lead Model
 */

require_once __DIR__ . '/../includes/db.php';

class Lead {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /**
     * Create a new lead
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO leads (
                user_id, name, email, phone, address, service_type, 
                preferred_date, preferred_time_window, property_type, 
                size_info, message, is_callback_request, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['user_id'] ?? null,
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['service_type'],
            $data['preferred_date'] ?? null,
            $data['preferred_time_window'] ?? null,
            $data['property_type'] ?? 'House',
            $data['size_info'] ?? null,
            $data['message'] ?? null,
            $data['is_callback_request'] ? 1 : 0,
            $data['status'] ?? 'New'
        ]);
    }

    /**
     * Get all leads with filters
     */
    public function getAll($filters = []) {
        $sql = "SELECT l.*, u.name as user_name, e.name as employee_name 
                FROM leads l 
                LEFT JOIN users u ON l.user_id = u.id 
                LEFT JOIN employees e ON l.assigned_employee_id = e.id 
                WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND l.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['service_type'])) {
            $sql .= " AND l.service_type = ?";
            $params[] = $filters['service_type'];
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(l.created_at) >= ?";
            $params[] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(l.created_at) <= ?";
            $params[] = $filters['date_to'];
        }

        $sql .= " ORDER BY l.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Get lead by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("
            SELECT l.*, u.name as user_name, e.name as employee_name 
            FROM leads l 
            LEFT JOIN users u ON l.user_id = u.id 
            LEFT JOIN employees e ON l.assigned_employee_id = e.id 
            WHERE l.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get leads by user ID
     */
    public function getByUserId($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM leads WHERE user_id = ? ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Update lead
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $id;
        $sql = "UPDATE leads SET " . implode(', ', $fields) . " WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Get lead statistics
     */
    public function getStatistics($dateFrom = null, $dateTo = null) {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'New' THEN 1 ELSE 0 END) as new_count,
                    SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress_count,
                    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_count,
                    SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_count
                FROM leads WHERE 1=1";
        $params = [];

        if ($dateFrom) {
            $sql .= " AND DATE(created_at) >= ?";
            $params[] = $dateFrom;
        }

        if ($dateTo) {
            $sql .= " AND DATE(created_at) <= ?";
            $params[] = $dateTo;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
}

