-- =============================================
-- School Admission Portal - Database Schema
-- PHP 8.x + MySQL
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- =============================================
-- Database Creation
-- =============================================
CREATE DATABASE IF NOT EXISTS `school_admission`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `school_admission`;

-- =============================================
-- Table: applications (Master Record)
-- =============================================
CREATE TABLE `applications` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `application_id` VARCHAR(20) DEFAULT NULL UNIQUE COMMENT 'Public ID e.g., ADM-2024-00001 (generated on submission)',
    `token` VARCHAR(64) NOT NULL UNIQUE COMMENT 'Session token for draft retrieval',
    `status` ENUM('draft', 'submitted', 'confirmed') NOT NULL DEFAULT 'draft',
    `current_step` TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Current form step (1-3)',
    `is_existing_student` TINYINT(1) DEFAULT NULL COMMENT 'From review page',
    `terms_accepted` TINYINT(1) NOT NULL DEFAULT 0,
    `ip_address` VARCHAR(45) DEFAULT NULL COMMENT 'IPv4 or IPv6',
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `submitted_at` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX `idx_token` (`token`),
    INDEX `idx_status` (`status`),
    INDEX `idx_application_id` (`application_id`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: students (Step 1 - Personal Information)
-- =============================================
CREATE TABLE `students` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `application_id` INT UNSIGNED NOT NULL,

    -- Student Information
    `full_name` VARCHAR(100) NOT NULL,
    `gender` ENUM('Male', 'Female', 'Other') NOT NULL,
    `date_of_birth` DATE NOT NULL,
    `class_applying` VARCHAR(20) NOT NULL COMMENT 'Pre-KG to Class 12',
    `community` VARCHAR(20) DEFAULT NULL COMMENT 'General, OBC, SC, ST',
    `emis_number` VARCHAR(50) DEFAULT NULL,

    -- Contact Information
    `father_mobile` VARCHAR(15) NOT NULL,
    `mother_mobile` VARCHAR(15) NOT NULL,
    `parent_email` VARCHAR(100) NOT NULL,
    `residential_address` TEXT NOT NULL,

    -- Academic & Preferences
    `previous_school` VARCHAR(200) DEFAULT NULL,
    `maths_type` ENUM('Basic', 'Standard') DEFAULT NULL COMMENT 'Class 10 maths type',
    `subject_pref_1` VARCHAR(100) DEFAULT NULL COMMENT 'Subject group preference 1',
    `subject_pref_2` VARCHAR(100) DEFAULT NULL COMMENT 'Subject group preference 2',
    `subject_pref_3` VARCHAR(100) DEFAULT NULL COMMENT 'Subject group preference 3',
    `subject_pref_4` VARCHAR(100) DEFAULT NULL COMMENT 'Subject group preference 4',
    `integrated_course` ENUM('Yes', 'No') DEFAULT 'No' COMMENT 'Apply for integrated course',

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (`application_id`) REFERENCES `applications`(`id`) ON DELETE CASCADE,
    INDEX `idx_application_id` (`application_id`),
    INDEX `idx_parent_email` (`parent_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: parents (Step 2 - Parent & Guardian Details)
-- =============================================
CREATE TABLE `parents` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `application_id` INT UNSIGNED NOT NULL,
    `parent_type` ENUM('father', 'mother', 'guardian') NOT NULL,

    `full_name` VARCHAR(100) DEFAULT NULL,
    `qualification` VARCHAR(50) DEFAULT NULL COMMENT 'High School, Undergraduate, Postgraduate, Doctorate, Other',
    `occupation` VARCHAR(100) DEFAULT NULL,
    `annual_income` DECIMAL(15, 2) DEFAULT NULL,
    `office_address` TEXT DEFAULT NULL,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (`application_id`) REFERENCES `applications`(`id`) ON DELETE CASCADE,
    INDEX `idx_application_id` (`application_id`),
    UNIQUE KEY `unique_parent_type` (`application_id`, `parent_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: rate_limits (For API Rate Limiting)
-- =============================================
CREATE TABLE `rate_limits` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `ip_address` VARCHAR(45) NOT NULL,
    `endpoint` VARCHAR(100) NOT NULL,
    `requests` INT UNSIGNED NOT NULL DEFAULT 1,
    `window_start` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY `unique_ip_endpoint` (`ip_address`, `endpoint`),
    INDEX `idx_window_start` (`window_start`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: csrf_tokens (CSRF Protection)
-- =============================================
CREATE TABLE `csrf_tokens` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `token` VARCHAR(64) NOT NULL UNIQUE,
    `session_token` VARCHAR(64) NOT NULL COMMENT 'Application session token',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `expires_at` TIMESTAMP NOT NULL,

    INDEX `idx_token` (`token`),
    INDEX `idx_session_token` (`session_token`),
    INDEX `idx_expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: application_logs (Audit Trail)
-- =============================================
CREATE TABLE `application_logs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `application_id` INT UNSIGNED NOT NULL,
    `action` VARCHAR(50) NOT NULL COMMENT 'created, step1_saved, step2_saved, submitted, email_sent',
    `details` JSON DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (`application_id`) REFERENCES `applications`(`id`) ON DELETE CASCADE,
    INDEX `idx_application_id` (`application_id`),
    INDEX `idx_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Stored Procedure: Generate Application ID
-- =============================================
DELIMITER //

CREATE PROCEDURE `generate_application_id`(OUT new_app_id VARCHAR(20))
BEGIN
    DECLARE current_year INT;
    DECLARE next_number INT;

    SET current_year = YEAR(CURDATE());

    SELECT COALESCE(MAX(CAST(SUBSTRING(application_id, 10) AS UNSIGNED)), 0) + 1
    INTO next_number
    FROM applications
    WHERE application_id LIKE CONCAT('ADM-', current_year, '-%');

    SET new_app_id = CONCAT('ADM-', current_year, '-', LPAD(next_number, 5, '0'));
END //

DELIMITER ;

-- =============================================
-- Event: Clean up expired drafts (older than 7 days)
-- =============================================
DELIMITER //

CREATE EVENT IF NOT EXISTS `cleanup_expired_drafts`
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_TIMESTAMP
DO
BEGIN
    DELETE FROM applications
    WHERE status = 'draft'
    AND created_at < DATE_SUB(NOW(), INTERVAL 7 DAY);

    DELETE FROM rate_limits
    WHERE window_start < DATE_SUB(NOW(), INTERVAL 1 HOUR);

    DELETE FROM csrf_tokens
    WHERE expires_at < NOW();
END //

DELIMITER ;

-- Enable event scheduler
SET GLOBAL event_scheduler = ON;
