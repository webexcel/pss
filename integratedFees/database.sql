-- Integrated Course Fee Payments Table
-- Run this SQL in your existing school database

CREATE TABLE IF NOT EXISTS `integrated_fee_payments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` VARCHAR(50) NOT NULL COMMENT 'Razorpay order_id',
  `adno` VARCHAR(50) NOT NULL COMMENT 'Student admission number',
  `mobile` VARCHAR(20) NOT NULL COMMENT 'Parent mobile',
  `amount` DOUBLE NOT NULL COMMENT 'Amount in INR',
  `status` ENUM('START','COMPLETED','CANCELLED','FAILED') NOT NULL DEFAULT 'START',
  `Year_Id` INT NOT NULL COMMENT 'Academic year',
  `reference` VARCHAR(50) DEFAULT NULL COMMENT 'Receipt reference',
  `start_time` DATETIME NOT NULL COMMENT 'Order creation time',
  `end_time` DATETIME DEFAULT NULL COMMENT 'Payment completion time',
  `remarks` VARCHAR(100) DEFAULT NULL,
  `payment_id` VARCHAR(50) DEFAULT NULL COMMENT 'Razorpay payment_id',
  `sett_date` DATE DEFAULT NULL COMMENT 'Settlement date',
  `sett_id` VARCHAR(100) DEFAULT NULL COMMENT 'Settlement ID',
  `paydetails` TEXT NOT NULL COMMENT 'JSON payment response',
  `signature` VARCHAR(500) DEFAULT NULL COMMENT 'Razorpay signature',
  `payment_type` ENUM('FULL','INST1','INST2') NOT NULL COMMENT 'Payment type',
  `fee_description` VARCHAR(100) DEFAULT 'Integrated Course Fee',

  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_order_id` (`order_id`),
  UNIQUE KEY `idx_payment_id` (`payment_id`),
  INDEX `idx_adno` (`adno`),
  INDEX `idx_status` (`status`),
  INDEX `idx_adno_type` (`adno`, `payment_type`),
  INDEX `idx_year` (`Year_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Add constraint to prevent duplicate completed payments
-- (One FULL payment OR one INST1 + one INST2 per student)
-- This is enforced in application logic, but you can add a trigger if needed
