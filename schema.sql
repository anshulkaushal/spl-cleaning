-- SparklePro Cleaning Services Database Schema
-- Run this SQL file in your MySQL database via phpMyAdmin or command line

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Create database (uncomment if needed)
-- CREATE DATABASE IF NOT EXISTS sparklepro_cleaning DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE sparklepro_cleaning;

-- Table: users (customers)
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('customer','admin','employee') DEFAULT 'customer',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: admin_users (separate admin table for simplicity)
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: services
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `base_price` decimal(10,2) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: employees (created before leads to support foreign key)
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `role` varchar(100) DEFAULT 'Cleaner',
  `active_status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `active_status` (`active_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: leads (quote/callback requests)
CREATE TABLE IF NOT EXISTS `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `preferred_date` date DEFAULT NULL,
  `preferred_time_window` varchar(100) DEFAULT NULL,
  `property_type` enum('House','Apartment','Office','Other') DEFAULT 'House',
  `size_info` varchar(255) DEFAULT NULL,
  `message` text,
  `is_callback_request` tinyint(1) DEFAULT 0,
  `status` enum('New','In Progress','Completed','Cancelled') DEFAULT 'New',
  `assigned_employee_id` int(11) DEFAULT NULL,
  `notes` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `assigned_employee_id` (`assigned_employee_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`assigned_employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: employee_schedules
CREATE TABLE IF NOT EXISTS `employee_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_description` text,
  `job_address` text NOT NULL,
  `job_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('Scheduled','In Progress','Completed','Cancelled') DEFAULT 'Scheduled',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `lead_id` (`lead_id`),
  KEY `job_date` (`job_date`),
  KEY `status` (`status`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cv_applications
CREATE TABLE IF NOT EXISTS `cv_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `position` enum('Cleaner','Supervisor','Admin','Other') DEFAULT 'Cleaner',
  `experience_years` int(11) DEFAULT NULL,
  `experience_text` text,
  `preferred_work_type` enum('Full-time','Part-time','Casual') DEFAULT 'Full-time',
  `cv_filename` varchar(255) NOT NULL,
  `status` enum('New','Shortlisted','Rejected','Hired') DEFAULT 'New',
  `notes` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: admin123 - CHANGE THIS AFTER FIRST LOGIN!)
-- Password hash for 'admin123'
INSERT INTO `admin_users` (`name`, `email`, `password_hash`) VALUES
('Admin User', 'admin@sparklepro.com', '$2y$12$ilN0wY8eu/T9H1FMsOsvreXEDAfVQq7lhdYczVwQ35ZB6A5zED0SC');

-- Insert sample services
INSERT INTO `services` (`name`, `description`, `base_price`, `icon`) VALUES
('House Cleaning', 'Regular house cleaning service for your home', 80.00, 'home'),
('Office Cleaning', 'Professional office cleaning services', 150.00, 'briefcase'),
('Move-In/Move-Out Clean', 'Deep cleaning for moving in or out', 200.00, 'truck'),
('Deep Cleaning', 'Thorough deep cleaning service', 250.00, 'sparkles'),
('Carpet Cleaning', 'Professional carpet and rug cleaning', 120.00, 'carpet'),
('Window Cleaning', 'Interior and exterior window cleaning', 100.00, 'window'),
('Construction Clean', 'Post-construction cleanup service', 300.00, 'hammer'),
('Regular Maintenance', 'Weekly or bi-weekly maintenance cleaning', 70.00, 'calendar');

-- Insert sample employees
INSERT INTO `employees` (`name`, `email`, `phone`, `role`, `active_status`) VALUES
('John Smith', 'john.smith@sparklepro.com', '555-0101', 'Cleaner', 1),
('Sarah Johnson', 'sarah.johnson@sparklepro.com', '555-0102', 'Supervisor', 1),
('Mike Davis', 'mike.davis@sparklepro.com', '555-0103', 'Cleaner', 1);

