-- Clarion PSMUN Registration Fee Payments
-- Run this SQL in the school database (same database as integratedFees)

CREATE TABLE IF NOT EXISTS `psmun_fee_payments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` VARCHAR(50) NOT NULL COMMENT 'Razorpay order_id',
  `receipt` VARCHAR(40) NOT NULL COMMENT 'Our receipt reference',
  `student_type` ENUM('INTERNAL','EXTERNAL') NOT NULL COMMENT 'INTERNAL = our school, EXTERNAL = other school',
  `adno` VARCHAR(50) DEFAULT NULL COMMENT 'Admission number (our students only)',
  `school_name` VARCHAR(150) DEFAULT NULL COMMENT 'Other school students only',
  `branch` VARCHAR(100) DEFAULT NULL COMMENT 'Other school branch, if any',
  `contact_name` VARCHAR(100) NOT NULL COMMENT 'Student / contact person',
  `mobile` VARCHAR(20) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `delegate_count` INT NOT NULL DEFAULT 1,
  `delegates` TEXT NOT NULL COMMENT 'JSON list of {name, class}',
  `amount` DOUBLE NOT NULL COMMENT 'Amount in INR',
  `status` ENUM('START','COMPLETED','CANCELLED','FAILED') NOT NULL DEFAULT 'START',
  `start_time` DATETIME NOT NULL COMMENT 'Order creation time',
  `end_time` DATETIME DEFAULT NULL COMMENT 'Payment completion time',
  `payment_id` VARCHAR(50) DEFAULT NULL COMMENT 'Razorpay payment_id',
  `signature` VARCHAR(500) DEFAULT NULL COMMENT 'Razorpay signature',
  `paydetails` TEXT NOT NULL COMMENT 'JSON payment response',
  `email_sent_at` DATETIME DEFAULT NULL COMMENT 'Confirmation email sent time',

  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_order_id` (`order_id`),
  UNIQUE KEY `idx_payment_id` (`payment_id`),
  INDEX `idx_type_status` (`student_type`, `status`),
  INDEX `idx_adno` (`adno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
