<?php
/**
 * Schedule Model
 */

require_once __DIR__ . '/../includes/db.php';

class Schedule {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /**
     * Create a new schedule entry
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO employee_schedules (
                employee_id, lead_id, job_title, job_description, 
                job_address, job_date, start_time, end_time, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['employee_id'],
            $data['lead_id'] ?? null,
            $data['job_title'],
            $data['job_description'] ?? null,
            $data['job_address'],
            $data['job_date'],
            $data['start_time'],
            $data['end_time'],
            $data['status'] ?? 'Scheduled'
        ]);
    }

    /**
     * Get all schedules with filters
     */
    public function getAll($filters = []) {
        $sql = "SELECT s.*, e.name as employee_name, l.name as lead_name 
                FROM employee_schedules s 
                LEFT JOIN employees e ON s.employee_id = e.id 
                LEFT JOIN leads l ON s.lead_id = l.id 
                WHERE 1=1";
        $params = [];

        if (!empty($filters['employee_id'])) {
            $sql .= " AND s.employee_id = ?";
            $params[] = $filters['employee_id'];
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND s.job_date >= ?";
            $params[] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND s.job_date <= ?";
            $params[] = $filters['date_to'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND s.status = ?";
            $params[] = $filters['status'];
        }

        $sql .= " ORDER BY s.job_date, s.start_time";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Get schedule by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("
            SELECT s.*, e.name as employee_name, l.name as lead_name 
            FROM employee_schedules s 
            LEFT JOIN employees e ON s.employee_id = e.id 
            LEFT JOIN leads l ON s.lead_id = l.id 
            WHERE s.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Update schedule
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $id;
        $sql = "UPDATE employee_schedules SET " . implode(', ', $fields) . " WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Get schedules for today
     */
    public function getTodaySchedules() {
        $stmt = $this->db->prepare("
            SELECT s.*, e.name as employee_name 
            FROM employee_schedules s 
            LEFT JOIN employees e ON s.employee_id = e.id 
            WHERE s.job_date = CURDATE() 
            ORDER BY s.start_time
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get employee workload statistics
     */
    public function getEmployeeWorkload($employeeId, $dateFrom, $dateTo) {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as total_tasks,
                SUM(CASE WHEN status = 'Scheduled' THEN 1 ELSE 0 END) as scheduled_count,
                SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress_count,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_count,
                SUM(TIMESTAMPDIFF(HOUR, CONCAT(job_date, ' ', start_time), CONCAT(job_date, ' ', end_time))) as total_hours
            FROM employee_schedules 
            WHERE employee_id = ? 
            AND job_date >= ? 
            AND job_date <= ?
        ");
        $stmt->execute([$employeeId, $dateFrom, $dateTo]);
        return $stmt->fetch();
    }
}

