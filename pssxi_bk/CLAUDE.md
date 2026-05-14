# Claude Context File - School Admission Portal

## Project Location
```
C:\xampp\htdocs\pssxi
```

## What This Project Is
A **multi-step admission form** web application built with:
- **Backend**: PHP 8.x + MySQL
- **Frontend**: HTML + Tailwind CSS + Vanilla JavaScript
- **Security**: CSRF protection, Rate limiting, reCAPTCHA v2, Input validation

## Architecture

### 3-Step Form Flow
1. **Step 1** (`step1.php`) - Student personal information
2. **Step 2** (`step2.php`) - Parent & guardian details
3. **Step 3** (`step3.php`) - Review & submit with reCAPTCHA

### Key Directories
| Directory | Purpose |
|-----------|---------|
| `api/` | REST API backend |
| `api/controllers/` | AdmissionController handles all endpoints |
| `api/models/` | Application, Student, ParentModel classes |
| `api/middleware/` | CSRF, RateLimiter, Recaptcha |
| `api/validators/` | Server-side validation rules |
| `config/` | Configuration files (database, mail, recaptcha) |
| `includes/` | PHP helpers, header/footer templates |
| `assets/js/` | JavaScript form handler |
| `sql/` | Database schema |

### Database Tables
- `applications` - Master record with status tracking
- `students` - Step 1 data (personal info)
- `parents` - Step 2 data (father/mother/guardian)
- `rate_limits` - API rate limiting
- `csrf_tokens` - CSRF protection
- `application_logs` - Audit trail

### API Endpoints
```
POST /api/application/start          → Start new application
GET  /api/application/{token}        → Get application data
POST /api/application/{token}/step1  → Save personal info
POST /api/application/{token}/step2  → Save parent details
POST /api/application/{token}/submit → Final submission
POST /api/application/{token}/draft  → Save as draft
POST /api/application/{token}/reset  → Reset form
```

## Configuration Files
| File | Purpose |
|------|---------|
| `config/database.php` | MySQL credentials |
| `config/mail.php` | SMTP email settings |
| `config/recaptcha.txt` | Google reCAPTCHA keys |
| `config/app.php` | App settings, form options |

## Security Features Implemented
- PDO prepared statements (SQL injection prevention)
- htmlspecialchars() output encoding (XSS prevention)
- CSRF token validation
- Rate limiting (50 requests/hour/IP)
- Google reCAPTCHA v2 on submission
- Security headers via .htaccess
- Input validation & sanitization

## Email Confirmation
Sends HTML email to parent's email on successful submission via PHPMailer-style SMTP or PHP mail().

## How to Continue Development

### To modify form fields:
1. Update `step1.php` or `step2.php` (frontend)
2. Update `api/validators/AdmissionValidator.php` (validation)
3. Update `api/models/Student.php` or `ParentModel.php` (database)
4. Update `sql/schema.sql` if adding new columns

### To add new API endpoint:
1. Add method in `api/controllers/AdmissionController.php`
2. Add route in `api/index.php`

### To modify email template:
Edit `api/config/Mailer.php` → `getConfirmationTemplate()` method

## URLs
- Application: http://localhost/pssxi/
- Step 1: http://localhost/pssxi/step1.php
- Step 2: http://localhost/pssxi/step2.php
- Step 3: http://localhost/pssxi/step3.php
- API: http://localhost/pssxi/api/

## Dependencies
- PHP 8.x
- MySQL 5.7+
- Apache with mod_rewrite
- No Composer packages (vanilla PHP)
