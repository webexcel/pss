<?php

declare(strict_types=1);

namespace Api\Validators;

/**
 * Admission Form Validator
 *
 * Handles server-side validation for all form steps
 */
class AdmissionValidator
{
    private array $errors = [];
    private array $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 2) . '/config/app.php';
    }

    /**
     * Get validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Check if validation passed
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Clear errors
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Add an error
     */
    private function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    /**
     * Validate Step 1: Personal Information
     */
    public function validateStep1(array $data): bool
    {
        $this->clearErrors();

        // Required fields
        $this->validateRequired($data, 'full_name', 'Full name is required');
        $this->validateRequired($data, 'gender', 'Gender is required');
        $this->validateRequired($data, 'date_of_birth', 'Date of birth is required');
        $this->validateRequired($data, 'class_applying', 'Class applying for is required');
        $this->validateRequired($data, 'father_mobile', "Father's mobile is required");
        $this->validateRequired($data, 'mother_mobile', "Mother's mobile is required");
        $this->validateRequired($data, 'parent_email', "Parent's email is required");
        $this->validateRequired($data, 'residential_address', 'Residential address is required');

        // Field-specific validations
        if (!empty($data['full_name'])) {
            $this->validateLength($data, 'full_name', 2, 100, 'Full name');
            $this->validateName($data['full_name'], 'full_name');
        }

        if (!empty($data['gender'])) {
            $this->validateInArray($data, 'gender', ['Male', 'Female', 'Other'], 'Invalid gender');
        }

        if (!empty($data['date_of_birth'])) {
            $this->validateDate($data['date_of_birth'], 'date_of_birth');
            $this->validateAge($data['date_of_birth'], 'date_of_birth');
        }

        if (!empty($data['class_applying'])) {
            $this->validateInArray($data, 'class_applying', $this->config['class_options'], 'Invalid class selection');
        }

        if (!empty($data['community'])) {
            $this->validateInArray($data, 'community', $this->config['community_options'], 'Invalid community');
        }

        if (!empty($data['father_mobile'])) {
            $this->validatePhone($data['father_mobile'], 'father_mobile', "Father's mobile");
        }

        if (!empty($data['mother_mobile'])) {
            $this->validatePhone($data['mother_mobile'], 'mother_mobile', "Mother's mobile");
        }

        if (!empty($data['parent_email'])) {
            $this->validateEmail($data['parent_email'], 'parent_email');
        }

        if (!empty($data['residential_address'])) {
            $this->validateLength($data, 'residential_address', 10, 500, 'Address');
        }

        if (!empty($data['emis_number'])) {
            $this->validateLength($data, 'emis_number', 1, 50, 'EMIS Number');
        }

        if (!empty($data['previous_school'])) {
            $this->validateLength($data, 'previous_school', 2, 200, 'Previous school');
        }

        if (!empty($data['maths_type'])) {
            $this->validateInArray($data, 'maths_type', ['Basic', 'Standard'], 'Invalid maths type');
        }

        // Subject preferences validation
        foreach (['subject_pref_1', 'subject_pref_2', 'subject_pref_3', 'subject_pref_4'] as $pref) {
            if (!empty($data[$pref])) {
                $this->validateInArray($data, $pref, $this->config['subject_groups'], 'Invalid subject group');
            }
        }

        return $this->isValid();
    }

    /**
     * Validate Step 2: Parent Details
     */
    public function validateStep2(array $data): bool
    {
        $this->clearErrors();

        // Father's details (required)
        if (empty($data['father']) || !is_array($data['father'])) {
            $this->addError('father', "Father's details are required");
        } else {
            $this->validateParentData($data['father'], 'father');
        }

        // Mother's details (required)
        if (empty($data['mother']) || !is_array($data['mother'])) {
            $this->addError('mother', "Mother's details are required");
        } else {
            $this->validateParentData($data['mother'], 'mother');
        }

        // Guardian (optional, but validate if enabled)
        if (!empty($data['guardian_enabled']) && !empty($data['guardian'])) {
            $this->validateParentData($data['guardian'], 'guardian', false);
        }

        return $this->isValid();
    }

    /**
     * Validate parent/guardian data
     */
    private function validateParentData(array $data, string $prefix, bool $required = true): void
    {
        $label = ucfirst($prefix);

        if ($required) {
            if (empty($data['full_name'])) {
                $this->addError("{$prefix}_full_name", "{$label}'s name is required");
            }
        }

        if (!empty($data['full_name'])) {
            if (strlen($data['full_name']) < 2 || strlen($data['full_name']) > 100) {
                $this->addError("{$prefix}_full_name", "{$label}'s name must be 2-100 characters");
            }
            if (!preg_match('/^[a-zA-Z\s\.\'-]+$/', $data['full_name'])) {
                $this->addError("{$prefix}_full_name", "{$label}'s name contains invalid characters");
            }
        }

        if (!empty($data['qualification'])) {
            $validQualifications = array_keys($this->config['qualification_options']);
            if (!in_array($data['qualification'], $validQualifications)) {
                $this->addError("{$prefix}_qualification", "Invalid qualification for {$label}");
            }
        }

        if (!empty($data['occupation'])) {
            if (strlen($data['occupation']) > 100) {
                $this->addError("{$prefix}_occupation", "{$label}'s occupation is too long");
            }
        }

        if (!empty($data['annual_income'])) {
            $income = preg_replace('/[^0-9.]/', '', $data['annual_income']);
            if (!is_numeric($income) || $income < 0) {
                $this->addError("{$prefix}_annual_income", "Invalid income for {$label}");
            }
        }

        if (!empty($data['office_address'])) {
            if (strlen($data['office_address']) > 500) {
                $this->addError("{$prefix}_office_address", "{$label}'s office address is too long");
            }
        }
    }

    /**
     * Validate Step 3: Review & Submit
     */
    public function validateStep3(array $data): bool
    {
        $this->clearErrors();

        if (!isset($data['is_existing_student'])) {
            $this->addError('is_existing_student', 'Please indicate if you are a current student');
        }

        if (empty($data['terms_accepted']) || $data['terms_accepted'] !== true) {
            $this->addError('terms_accepted', 'You must accept the terms and declaration');
        }

        return $this->isValid();
    }

    // ========================================
    // Helper validation methods
    // ========================================

    private function validateRequired(array $data, string $field, string $message): void
    {
        if (empty($data[$field]) || (is_string($data[$field]) && trim($data[$field]) === '')) {
            $this->addError($field, $message);
        }
    }

    private function validateLength(array $data, string $field, int $min, int $max, string $label): void
    {
        $length = strlen(trim($data[$field] ?? ''));
        if ($length < $min || $length > $max) {
            $this->addError($field, "{$label} must be between {$min} and {$max} characters");
        }
    }

    private function validateInArray(array $data, string $field, array $allowed, string $message): void
    {
        if (!in_array($data[$field], $allowed)) {
            $this->addError($field, $message);
        }
    }

    private function validateName(string $value, string $field): void
    {
        if (!preg_match('/^[a-zA-Z\s\.\'-]+$/', $value)) {
            $this->addError($field, 'Name contains invalid characters');
        }
    }

    private function validateEmail(string $email, string $field): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'Invalid email address');
        }
    }

    private function validatePhone(string $phone, string $field, string $label): void
    {
        // Remove spaces, dashes, parentheses
        $cleaned = preg_replace('/[\s\-\(\)\+]/', '', $phone);

        if (!preg_match('/^[0-9]{10,15}$/', $cleaned)) {
            $this->addError($field, "{$label} must be a valid phone number (10-15 digits)");
        }
    }

    private function validateDate(string $date, string $field): void
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        if (!$d || $d->format('Y-m-d') !== $date) {
            $this->addError($field, 'Invalid date format');
        }
    }

    private function validateAge(string $dateOfBirth, string $field): void
    {
        $dob = new \DateTime($dateOfBirth);
        $today = new \DateTime();
        $age = $today->diff($dob)->y;

        if ($age < 2 || $age > 25) {
            $this->addError($field, 'Student age must be between 2 and 25 years');
        }
    }

    /**
     * Sanitize input data
     */
    public function sanitize(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = $this->sanitize($value);
            } elseif (is_string($value)) {
                // Trim whitespace
                $value = trim($value);
                // Remove null bytes
                $value = str_replace("\0", '', $value);
                // Convert special characters to HTML entities
                $sanitized[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Decode sanitized data for database storage
     */
    public function decode(array $data): array
    {
        $decoded = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $decoded[$key] = $this->decode($value);
            } elseif (is_string($value)) {
                $decoded[$key] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
            } else {
                $decoded[$key] = $value;
            }
        }

        return $decoded;
    }
}
