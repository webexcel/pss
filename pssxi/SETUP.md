# School Admission Portal - Setup Guide

## Project Overview
Multi-step admission form with PHP 8.x + MySQL backend.

## Quick Start

### 1. Move to XAMPP
Copy the `pssxi` folder to:
```
C:\xampp\htdocs\pssxi
```

### 2. Create Database
Open phpMyAdmin (http://localhost/phpmyadmin) and run:
```sql
SOURCE C:/xampp/htdocs/pssxi/sql/schema.sql;
```
Or import the file: `sql/schema.sql`

### 3. Configure Database
Edit `config/database.php`:
```php
return [
    'host'     => 'localhost',
    'port'     => 3306,
    'database' => 'school_admission',
    'username' => 'root',
    'password' => '',  // XAMPP default is empty
    ...
];
```

### 4. Configure reCAPTCHA
Edit `config/recaptcha.txt`:
```
SITE_KEY=your-site-key-here
SECRET_KEY=your-secret-key-here
```
Get keys from: https://www.google.com/recaptcha/admin

### 5. Configure Email (Optional)
Edit `config/mail.php` with your SMTP settings.

### 6. Access the Application
Open: http://localhost/pssxi/

## File Structure
```
pssxi/
├── api/                    # REST API
│   ├── config/            # DB & Mail classes
│   ├── controllers/       # AdmissionController
│   ├── middleware/        # CSRF, RateLimiter, Recaptcha
│   ├── models/            # Application, Student, ParentModel
│   ├── validators/        # Form validation
│   └── index.php          # API router
├── assets/js/             # JavaScript
├── config/                # Configuration files
├── includes/              # PHP includes
├── sql/                   # Database schema
├── step1.php              # Personal Info form
├── step2.php              # Parent Details form
├── step3.php              # Review & Submit
└── success.php            # Confirmation page
```

## API Endpoints
- POST `/api/application/start` - Start new application
- POST `/api/application/{token}/step1` - Save Step 1
- POST `/api/application/{token}/step2` - Save Step 2
- POST `/api/application/{token}/submit` - Submit application
- POST `/api/application/{token}/draft` - Save draft
- POST `/api/application/{token}/reset` - Reset form

## Troubleshooting

### "Class not found" errors
Ensure file paths match case-sensitivity.

### Database connection failed
- Check XAMPP MySQL is running
- Verify credentials in `config/database.php`
- Ensure database `school_admission` exists

### reCAPTCHA not working
- Add `localhost` to allowed domains in Google reCAPTCHA admin
- Check keys in `config/recaptcha.txt`

### Emails not sending
- Configure valid SMTP in `config/mail.php`
- For Gmail: Enable "Less secure apps" or use App Password
