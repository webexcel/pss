-- Run once on the existing psmun_fee_payments table (adds confirmation email tracking)

ALTER TABLE `psmun_fee_payments`
  ADD COLUMN `email_sent_at` DATETIME DEFAULT NULL COMMENT 'Confirmation email sent time' AFTER `paydetails`;
