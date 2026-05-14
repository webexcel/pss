# Integrated Course Fee Collection Microsite
## Implementation Plan (Using Existing Schema)

---

## 1. System Architecture Overview

### 1.1 High-Level Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                     MAIN SCHOOL WEBSITE                         │
│                    (External Link Button)                       │
└─────────────────────┬───────────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────────┐
│                 INTEGRATED FEES MICROSITE                       │
├─────────────────────────────────────────────────────────────────┤
│  ┌──────────┐   ┌──────────┐   ┌──────────┐   ┌──────────┐     │
│  │  Login   │ → │   Fee    │ → │ Payment  │ → │ Result   │     │
│  │(Adm. No.)│   │ Selection│   │ Checkout │   │   Page   │     │
│  └──────────┘   └──────────┘   └──────────┘   └──────────┘     │
├─────────────────────────────────────────────────────────────────┤
│                    EXISTING MySQL DATABASE                      │
│  ┌──────────────────────┐  ┌────────────────────────┐          │
│  │ v_currentstudentlist │  │ integrated_fee_payments│          │
│  │      (VIEW)          │  │      (NEW TABLE)       │          │
│  └──────────────────────┘  └────────────────────────┘          │
├─────────────────────────────────────────────────────────────────┤
│                     RAZORPAY GATEWAY                            │
└─────────────────────────────────────────────────────────────────┘
```

### 1.2 Simple Login Approach

**Login = Admission Number Only**

- No password required
- Session expires in 15 minutes (short-lived)
- Only displays: Student Name, Class, Fee Options
- No sensitive data exposed (no DOB, address, parent details shown)
- Session destroyed after payment completion or timeout

**Why this is acceptable:**
- Microsite only allows fee payment (no data modification)
- Student can only pay their own fees (no harm if someone else pays)
- No sensitive information displayed
- Razorpay handles actual payment security
- Short session timeout

### 1.3 Page Flow

```
[Login Page - index.php]
     │
     └──── Enter Admission No. ────► Validate against v_currentstudentlist
                                              │
                    ┌─────────────────────────┴─────────────────────────┐
                    │                                                   │
                NOT FOUND                                            FOUND
                    │                                                   │
                    ▼                                                   ▼
          "Invalid Admission No."                          Create Session (15 min)
                                                           Store: adno, name, class
                                                                   │
                                                                   ▼
                                                    [Fee Selection - fee-selection.php]
                                                           │
                                                           ▼
                                                    Display: Name, Class
                                                    Show: Payment Options
                                                           │
                              ┌─────────────────────────────┼─────────────────────────────┐
                              │                             │                             │
                              ▼                             ▼                             ▼
                      [Full ₹99,000]              [Inst 1 ₹55,000]              [Inst 2 ₹50,000]
                              │                             │                             │
                              └─────────────────────────────┴─────────────────────────────┘
                                                           │
                                                           ▼
                                               [Razorpay Checkout Modal]
                                                           │
                                              ┌────────────┴────────────┐
                                              ▼                         ▼
                                       [success.php]             [failure.php]
                                       Session Destroyed         Retry Option
```

### 1.4 Backend Components

| Component | Responsibility |
|-----------|----------------|
| `index.php` | Login page - admission number entry |
| `fee-selection.php` | Display fee options (requires session) |
| `create-order.php` | Create Razorpay order (AJAX, requires session) |
| `verify-payment.php` | Verify payment callback |
| `webhook.php` | Razorpay webhook handler |
| `success.php` | Success page, destroys session |
| `failure.php` | Failure page with retry |
| `logout.php` | Manual logout (optional) |
| `includes/config.php` | Configuration |
| `includes/db.php` | Database connection |
| `includes/session.php` | Session management |

---

## 2. Session Management (Simple Login)

### 2.1 Session Configuration

```
Session Lifetime: 15 minutes
Session Data Stored:
  - adno (Admission Number)
  - student_name
  - class_section
  - contact (for Razorpay prefill)
  - Year_Id
  - login_time
```

### 2.2 Session Flow

```
LOGIN (index.php):
─────────────────
1. User enters Admission No.
2. Query v_currentstudentlist
3. If found:
   - Start session
   - Store minimal data (name, class, contact, Year_Id)
   - Set session timeout = 15 minutes
   - Redirect to fee-selection.php
4. If not found:
   - Show error message

PROTECTED PAGES (fee-selection.php, create-order.php):
──────────────────────────────────────────────────────
1. Check if session exists
2. Check if session expired (15 min from login_time)
3. If invalid/expired → Redirect to index.php
4. If valid → Continue

LOGOUT/COMPLETION:
──────────────────
- success.php → Destroy session after showing receipt
- logout.php → Destroy session, redirect to index.php
- Session auto-expires after 15 minutes
```

### 2.3 Session Settings

```php
// Session configuration
ini_set('session.gc_maxlifetime', 900);  // 15 minutes
session_set_cookie_params(900);           // Cookie expires in 15 min

// Custom timeout check
$_SESSION['login_time'] = time();
$timeout = 900; // 15 minutes

if (time() - $_SESSION['login_time'] > $timeout) {
    session_destroy();
    redirect to login;
}
```

### 2.4 What Data is Displayed (Non-Sensitive)

| Shown | Not Shown |
|-------|-----------|
| Student Name | DOB |
| Class/Section | Address |
| Fee Amount | Parent Name |
| Payment Status | Contact Number |
| | Email |
| | EMIS |

**Note:** Contact/Email used internally for Razorpay prefill but not displayed on screen.

---

## 3. Database Design

### 3.1 Existing View: `v_currentstudentlist`

**Available fields we will use:**

| Field | Usage |
|-------|-------|
| `ADMISSION_ID` | Primary identifier for student lookup |
| `NAME` | Display on fee selection page |
| `CLASSSEC` | Display class/section info |
| `contact` | Pre-fill in Razorpay checkout |
| `email` | Pre-fill in Razorpay checkout (optional) |
| `Year_Id` | Current academic year reference |

**Sample Query:**
```sql
SELECT ADMISSION_ID, NAME, CLASSSEC, contact, email, Year_Id
FROM v_currentstudentlist
WHERE ADMISSION_ID = ?
```

### 3.2 New Table: `integrated_fee_payments`

This table follows your existing `razorpay` table conventions but adds fields specific to integrated course fee tracking.

```sql
CREATE TABLE `integrated_fee_payments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` VARCHAR(50) NOT NULL,
  `adno` VARCHAR(50) NOT NULL,
  `mobile` VARCHAR(20) NOT NULL,
  `amount` DOUBLE NOT NULL,
  `status` ENUM('START','COMPLETED','CANCELLED','FAILED') NOT NULL DEFAULT 'START',
  `Year_Id` INT NOT NULL,
  `reference` VARCHAR(50) DEFAULT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME DEFAULT NULL,
  `remarks` VARCHAR(100) DEFAULT NULL,
  `payment_id` VARCHAR(50) DEFAULT NULL,
  `sett_date` DATE DEFAULT NULL,
  `sett_id` VARCHAR(100) DEFAULT NULL,
  `paydetails` TEXT NOT NULL,
  `signature` VARCHAR(500) DEFAULT NULL,

  -- NEW FIELDS for Integrated Fee tracking
  `payment_type` ENUM('FULL','INST1','INST2') NOT NULL,
  `fee_description` VARCHAR(100) DEFAULT 'Integrated Course Fee',

  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_order_id` (`order_id`),
  UNIQUE KEY `idx_payment_id` (`payment_id`),
  INDEX `idx_adno` (`adno`),
  INDEX `idx_status` (`status`),
  INDEX `idx_adno_type` (`adno`, `payment_type`),
  INDEX `idx_year` (`Year_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

### 3.3 Field Mapping & Usage

| Field | Type | Description |
|-------|------|-------------|
| `id` | INT | Auto-increment primary key |
| `order_id` | VARCHAR(50) | Razorpay order_id (order_xxxxx) |
| `adno` | VARCHAR(50) | Student admission number (from `v_currentstudentlist.ADMISSION_ID`) |
| `mobile` | VARCHAR(20) | Parent mobile (from `v_currentstudentlist.contact`) |
| `amount` | DOUBLE | Amount in INR (99000, 55000, or 50000) |
| `status` | ENUM | `START` → `COMPLETED` / `FAILED` / `CANCELLED` |
| `Year_Id` | INT | Academic year (from `v_currentstudentlist.Year_Id`) |
| `reference` | VARCHAR(50) | Receipt reference (e.g., `ICFEE-2026-00001`) |
| `start_time` | DATETIME | When order was created |
| `end_time` | DATETIME | When payment completed/failed |
| `remarks` | VARCHAR(100) | Additional notes (e.g., "Full payment", "Installment 1") |
| `payment_id` | VARCHAR(50) | Razorpay payment_id (pay_xxxxx) |
| `sett_date` | DATE | Settlement date (from Razorpay webhook) |
| `sett_id` | VARCHAR(100) | Settlement ID (from Razorpay webhook) |
| `paydetails` | TEXT | JSON payload of payment response |
| `signature` | VARCHAR(500) | Razorpay signature for verification |
| **`payment_type`** | ENUM | **NEW:** `FULL`, `INST1`, or `INST2` |
| **`fee_description`** | VARCHAR(100) | **NEW:** Fee label for display |

### 3.4 Status Flow

```
START ──────► COMPLETED   (Payment successful)
  │
  ├────────► FAILED       (Payment failed)
  │
  └────────► CANCELLED    (User cancelled checkout)
```

---

## 3. Payment Flow

### 3.1 Full Payment Flow (₹99,000)

```
Student enters Admission No.
         │
         ▼
Query: SELECT * FROM v_currentstudentlist WHERE ADMISSION_ID = ?
         │
         ├─── NOT FOUND ───► Error: "Invalid Admission Number"
         │
         └─── FOUND ───► Check existing payments
                              │
                              ▼
Query: SELECT * FROM integrated_fee_payments
       WHERE adno = ? AND status = 'COMPLETED'
         │
         ├─── Has FULL payment ───► "Already Paid" message
         │
         ├─── Has INST1 only ───► Show only INST2 option (₹50,000)
         │
         ├─── Has INST1 + INST2 ───► "Already Paid" message
         │
         └─── No payments ───► Show both options:
                                   • Full Payment (₹99,000)
                                   • Installment Plan (₹55,000 + ₹50,000)
                                        │
                                        ▼
                              Student clicks "Pay ₹99,000"
                                        │
                                        ▼
                              [create-order.php]
                              1. Validate student exists
                              2. Verify no completed payments
                              3. Create Razorpay Order (amount: 9900000 paise)
                              4. INSERT into integrated_fee_payments:
                                 - order_id = razorpay order id
                                 - adno = admission number
                                 - mobile = contact from view
                                 - amount = 99000
                                 - status = 'START'
                                 - payment_type = 'FULL'
                                 - start_time = NOW()
                                 - remarks = 'Full Payment'
                              5. Return order_id to frontend
                                        │
                                        ▼
                              Razorpay Checkout opens
                                        │
                                        ▼
                              [verify-payment.php]
                              1. Verify signature
                              2. UPDATE integrated_fee_payments:
                                 - status = 'COMPLETED'
                                 - payment_id = razorpay_payment_id
                                 - signature = razorpay_signature
                                 - end_time = NOW()
                                 - paydetails = JSON response
                              3. Redirect to success.php
```

### 3.2 Installment Payment Flow

```
INSTALLMENT 1 (₹55,000):
────────────────────────

Student has NO completed payments
         │
         ▼
Show: "Pay in Installments" option
         │
         ▼
Student clicks "Pay Installment 1 - ₹55,000"
         │
         ▼
[create-order.php]
1. Verify no completed payments exist
2. Create Razorpay Order (amount: 5500000 paise)
3. INSERT into integrated_fee_payments:
   - payment_type = 'INST1'
   - amount = 55000
   - remarks = 'Installment 1 of 2'
4. Return order_id
         │
         ▼
[After successful payment]
- status = 'COMPLETED'
- Student now eligible for INST2


INSTALLMENT 2 (₹50,000):
────────────────────────

Student has INST1 with status = 'COMPLETED'
         │
         ▼
Show: "Pay Installment 2 - ₹50,000"
         │
         ▼
Student clicks "Pay Installment 2 - ₹50,000"
         │
         ▼
[create-order.php]
1. Verify INST1 is COMPLETED
2. Verify INST2 not already COMPLETED
3. Create Razorpay Order (amount: 5000000 paise)
4. INSERT into integrated_fee_payments:
   - payment_type = 'INST2'
   - amount = 50000
   - remarks = 'Installment 2 of 2 (Final)'
5. Return order_id
         │
         ▼
[After successful payment]
- status = 'COMPLETED'
- All payments complete
```

### 3.3 Payment Status Check Logic

**Query to determine what to show:**

```sql
-- Get all completed payments for student
SELECT payment_type, amount, status
FROM integrated_fee_payments
WHERE adno = ?
  AND status = 'COMPLETED'
ORDER BY payment_type;
```

**Decision Matrix:**

| Completed Payments | Show to User |
|--------------------|--------------|
| None | Full (₹99,000) OR Installment 1 (₹55,000) |
| FULL | "All fees paid. Thank you!" |
| INST1 only | Installment 2 (₹50,000) |
| INST1 + INST2 | "All fees paid. Thank you!" |

### 3.4 Preventing Duplicate/Over-Payments

| Scenario | Prevention |
|----------|------------|
| Double-click pay button | Disable button after click; unique `order_id` |
| Full payment after INST1 | Once INST1 exists (any status), hide FULL option |
| INST2 without INST1 | Server-side check: INST1 must be COMPLETED |
| INST2 paid twice | Check before order: no COMPLETED INST2 exists |
| Concurrent attempts | Use DB transaction; check before INSERT |

**Validation Queries (run before order creation):**

```sql
-- Before FULL payment:
SELECT COUNT(*) as cnt FROM integrated_fee_payments
WHERE adno = ? AND status = 'COMPLETED';
-- Must return 0

-- Before INST1:
SELECT COUNT(*) as cnt FROM integrated_fee_payments
WHERE adno = ? AND status = 'COMPLETED';
-- Must return 0

-- Before INST2:
SELECT COUNT(*) as cnt FROM integrated_fee_payments
WHERE adno = ? AND payment_type = 'INST1' AND status = 'COMPLETED';
-- Must return 1

SELECT COUNT(*) as cnt FROM integrated_fee_payments
WHERE adno = ? AND payment_type = 'INST2' AND status = 'COMPLETED';
-- Must return 0
```

---

## 4. Razorpay Integration Plan

### 4.1 SDK Setup

- Install: `composer require razorpay/razorpay`
- Store credentials in config file (outside web root)
- Use Test Mode during development

### 4.2 Order Creation

**Order attributes:**
```
{
  "amount": <amount_in_paise>,
  "currency": "INR",
  "receipt": "ICFEE-{adno}-{payment_type}-{timestamp}",
  "notes": {
    "adno": "...",
    "student_name": "...",
    "payment_type": "FULL|INST1|INST2",
    "fee_description": "Integrated Course Fee"
  }
}
```

**Amount Mapping (hardcoded server-side):**
```
FULL  → 9900000 paise (₹99,000)
INST1 → 5500000 paise (₹55,000)
INST2 → 5000000 paise (₹50,000)
```

### 4.3 Payment Verification

**On checkout success callback:**

1. Receive: `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`
2. Verify signature:
   ```
   expected = HMAC-SHA256(order_id + "|" + payment_id, key_secret)
   ```
3. If valid:
   - UPDATE record: `status = 'COMPLETED'`, `payment_id`, `signature`, `end_time`
   - Store full response in `paydetails`
   - Redirect to success.php
4. If invalid:
   - Log attempt
   - Redirect to failure.php

### 4.4 Webhook Handling (Recommended)

**Register webhook URL:** `https://yourdomain.com/integratedFees/webhook.php`

**Events to handle:**

| Event | Action |
|-------|--------|
| `payment.captured` | Verify & mark COMPLETED (backup to callback) |
| `payment.failed` | Mark FAILED, log reason |
| `order.paid` | Secondary confirmation |

**Webhook verification:**
- Validate `X-Razorpay-Signature` header
- Use webhook secret (configure in Razorpay Dashboard)
- Return 200 OK immediately
- Log all events

---

## 6. Security & Validation

### 6.1 Login Security (Minimal)

Since this is admission-number-only login with no sensitive data:

| Aspect | Approach |
|--------|----------|
| Authentication | Admission number only (no password) |
| Session Duration | 15 minutes (short-lived) |
| Sensitive Data | None displayed on screen |
| Risk if breached | Someone else pays fees (no harm) |

### 6.2 Amount Validation

| Layer | Action |
|-------|--------|
| Frontend | Display only; amounts not editable |
| Order Creation | Server determines amount from `payment_type` |
| Verification | Razorpay signature verification |

### 6.3 Basic Validation

| Input | Validation |
|-------|------------|
| `adno` | Must exist in `v_currentstudentlist` |
| `payment_type` | Must be: `FULL`, `INST1`, or `INST2` |
| Session | Must be valid and not expired |

### 6.4 Standard Practices

| Area | Implementation |
|------|----------------|
| SQL Injection | PDO prepared statements |
| XSS | `htmlspecialchars()` on output |
| Razorpay | Always verify signature |

---

## 7. Deployment Notes

### 7.1 Folder Structure

```
C:\xampp\htdocs\
├── [existing school website files]
│
└── integratedFees/                    # Microsite root
    ├── index.php                      # Landing page
    ├── fee-selection.php              # Fee options
    ├── create-order.php               # AJAX - order creation
    ├── verify-payment.php             # Payment callback
    ├── webhook.php                    # Razorpay webhook
    ├── success.php                    # Success page
    ├── failure.php                    # Failure page
    │
    ├── assets/
    │   ├── css/
    │   │   └── style.css
    │   └── js/
    │       └── payment.js
    │
    ├── includes/
    │   ├── config.php                 # DB & Razorpay config
    │   ├── db.php                     # DB connection
    │   ├── razorpay.php               # Razorpay wrapper
    │   └── functions.php              # Helper functions
    │
    └── templates/
        ├── header.php
        └── footer.php
```

### 7.2 Config File (includes/config.php)

```php
// Database - use existing school DB
define('DB_HOST', 'localhost');
define('DB_NAME', 'school_db');  // Your existing DB
define('DB_USER', 'xxx');
define('DB_PASS', 'xxx');

// Razorpay
define('RAZORPAY_KEY_ID', 'rzp_test_xxx');
define('RAZORPAY_KEY_SECRET', 'xxx');
define('RAZORPAY_WEBHOOK_SECRET', 'xxx');

// Fee amounts (in paise)
define('FEE_FULL', 9900000);
define('FEE_INST1', 5500000);
define('FEE_INST2', 5000000);
```

### 7.3 Linking from Main Website

```html
<a href="/integratedFees/" class="btn" target="_blank" rel="noopener">
  Pay Integrated Course Fee
</a>
```

### 7.4 Pre-Deployment Checklist

- [ ] Create `integrated_fee_payments` table
- [ ] Install Razorpay SDK via Composer
- [ ] Configure Razorpay API keys (Test mode first)
- [ ] Test full payment flow with test cards
- [ ] Test installment flow (INST1 → INST2)
- [ ] Register webhook URL in Razorpay Dashboard
- [ ] Switch to Live mode keys
- [ ] Verify HTTPS is working
- [ ] Test on mobile devices

---

## 8. Quick Reference

### 8.1 Fee Structure

| Option | Amount | When Available |
|--------|--------|----------------|
| Full Payment | ₹99,000 | No prior payments |
| Installment 1 | ₹55,000 | No prior payments |
| Installment 2 | ₹50,000 | After INST1 completed |

### 8.2 Status Values

| Status | Meaning |
|--------|---------|
| `START` | Order created, awaiting payment |
| `COMPLETED` | Payment successful |
| `FAILED` | Payment failed |
| `CANCELLED` | User cancelled |

### 8.3 Payment Type Values

| Type | Description |
|------|-------------|
| `FULL` | Single full payment of ₹99,000 |
| `INST1` | First installment of ₹55,000 |
| `INST2` | Second installment of ₹50,000 |

---

## 9. SQL Summary

### Create Table

```sql
CREATE TABLE `integrated_fee_payments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` VARCHAR(50) NOT NULL,
  `adno` VARCHAR(50) NOT NULL,
  `mobile` VARCHAR(20) NOT NULL,
  `amount` DOUBLE NOT NULL,
  `status` ENUM('START','COMPLETED','CANCELLED','FAILED') NOT NULL DEFAULT 'START',
  `Year_Id` INT NOT NULL,
  `reference` VARCHAR(50) DEFAULT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME DEFAULT NULL,
  `remarks` VARCHAR(100) DEFAULT NULL,
  `payment_id` VARCHAR(50) DEFAULT NULL,
  `sett_date` DATE DEFAULT NULL,
  `sett_id` VARCHAR(100) DEFAULT NULL,
  `paydetails` TEXT NOT NULL,
  `signature` VARCHAR(500) DEFAULT NULL,
  `payment_type` ENUM('FULL','INST1','INST2') NOT NULL,
  `fee_description` VARCHAR(100) DEFAULT 'Integrated Course Fee',

  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_order_id` (`order_id`),
  UNIQUE KEY `idx_payment_id` (`payment_id`),
  INDEX `idx_adno` (`adno`),
  INDEX `idx_status` (`status`),
  INDEX `idx_adno_type` (`adno`, `payment_type`),
  INDEX `idx_year` (`Year_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

### Key Queries

```sql
-- Validate student
SELECT ADMISSION_ID, NAME, CLASSSEC, contact, email, Year_Id
FROM v_currentstudentlist
WHERE ADMISSION_ID = ?;

-- Check payment status for student
SELECT payment_type, amount, status, end_time
FROM integrated_fee_payments
WHERE adno = ? AND status = 'COMPLETED'
ORDER BY payment_type;

-- Insert new order
INSERT INTO integrated_fee_payments
(order_id, adno, mobile, amount, status, Year_Id, start_time, remarks, paydetails, payment_type)
VALUES (?, ?, ?, ?, 'START', ?, NOW(), ?, '{}', ?);

-- Update on successful payment
UPDATE integrated_fee_payments
SET status = 'COMPLETED',
    payment_id = ?,
    signature = ?,
    end_time = NOW(),
    paydetails = ?
WHERE order_id = ?;
```

---

*Document Version: 2.0*
*Updated: January 2026*
*Status: Implementation Ready (Aligned with Existing Schema)*
