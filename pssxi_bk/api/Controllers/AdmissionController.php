<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Config\Database;
use Api\Models\Application;
use Api\Models\Student;
use Api\Models\ParentModel;
use Api\Validators\AdmissionValidator;
use Api\Config\Mailer;
use Api\Middleware\Recaptcha;

/**
 * Admission Controller
 *
 * Handles all API endpoints for the admission form
 */
class AdmissionController
{
    private Application $applicationModel;
    private Student $studentModel;
    private ParentModel $parentModel;
    private AdmissionValidator $validator;
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->applicationModel = new Application();
        $this->studentModel = new Student();
        $this->parentModel = new ParentModel();
        $this->validator = new AdmissionValidator();
    }

    /**
     * Start a new application
     * POST /api/application/start
     */
    public function startApplication(): array
    {
        try {
            $ipAddress = $this->getClientIp();
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

            $result = $this->applicationModel->create($ipAddress, $userAgent);

            return $this->success([
                'application_id' => $result['application_id'],
                'token'          => $result['token'],
                'current_step'   => 1,
            ], 'Application started successfully');

        } catch (\Exception $e) {
            error_log('Error starting application: ' . $e->getMessage());
            return $this->error('Failed to start application. Please try again.');
        }
    }

    /**
     * Get application data by token
     * GET /api/application/{token}
     */
    public function getApplication(string $token): array
    {
        $application = $this->applicationModel->findByToken($token);

        if (!$application) {
            return $this->error('Application not found', 404);
        }

        $data = $this->applicationModel->getCompleteData($application['id']);

        return $this->success($data);
    }

    /**
     * Save Step 1: Personal Information
     * POST /api/application/{token}/step1
     */
    public function saveStep1(string $token, array $data): array
    {
        $application = $this->applicationModel->findByToken($token);

        if (!$application) {
            return $this->error('Application not found', 404);
        }

        if (!$this->applicationModel->isEditable($application['id'])) {
            return $this->error('Application has already been submitted', 403);
        }

        // Sanitize and validate
        $data = $this->validator->sanitize($data);

        if (!$this->validator->validateStep1($data)) {
            return $this->validationError($this->validator->getErrors());
        }

        // Decode for storage
        $data = $this->validator->decode($data);

        try {
            $this->db->beginTransaction();

            // Save student data
            $this->studentModel->upsert($application['id'], $data);

            // Update application step
            $this->applicationModel->updateStep($application['id'], 2);

            // Log action
            $this->applicationModel->logAction(
                $application['id'],
                'step1_saved',
                ['fields_count' => count($data)],
                $this->getClientIp()
            );

            $this->db->commit();

            return $this->success([
                'current_step' => 2,
            ], 'Personal information saved successfully');

        } catch (\Exception $e) {
            $this->db->rollback();
            error_log('Error saving step 1: ' . $e->getMessage());
            return $this->error('Failed to save data. Please try again.');
        }
    }

    /**
     * Save Step 2: Parent Details
     * POST /api/application/{token}/step2
     */
    public function saveStep2(string $token, array $data): array
    {
        $application = $this->applicationModel->findByToken($token);

        if (!$application) {
            return $this->error('Application not found', 404);
        }

        if (!$this->applicationModel->isEditable($application['id'])) {
            return $this->error('Application has already been submitted', 403);
        }

        // Sanitize and validate
        $data = $this->validator->sanitize($data);

        if (!$this->validator->validateStep2($data)) {
            return $this->validationError($this->validator->getErrors());
        }

        // Decode for storage
        $data = $this->validator->decode($data);

        try {
            $this->db->beginTransaction();

            // Save parent data
            $this->parentModel->saveAll($application['id'], $data);

            // Update application step
            $this->applicationModel->updateStep($application['id'], 3);

            // Log action
            $this->applicationModel->logAction(
                $application['id'],
                'step2_saved',
                ['guardian_enabled' => !empty($data['guardian_enabled'])],
                $this->getClientIp()
            );

            $this->db->commit();

            return $this->success([
                'current_step' => 3,
            ], 'Parent details saved successfully');

        } catch (\Exception $e) {
            $this->db->rollback();
            error_log('Error saving step 2: ' . $e->getMessage());
            return $this->error('Failed to save data. Please try again.');
        }
    }

    /**
     * Get review data
     * GET /api/application/{token}/review
     */
    public function getReviewData(string $token): array
    {
        $application = $this->applicationModel->findByToken($token);

        if (!$application) {
            return $this->error('Application not found', 404);
        }

        $data = $this->applicationModel->getCompleteData($application['id']);

        if (!$data['student']) {
            return $this->error('Please complete Step 1 first', 400);
        }

        if (empty($data['parents'])) {
            return $this->error('Please complete Step 2 first', 400);
        }

        return $this->success($data);
    }

    /**
     * Submit application
     * POST /api/application/{token}/submit
     */
    public function submitApplication(string $token, array $data): array
    {
        $application = $this->applicationModel->findByToken($token);

        if (!$application) {
            return $this->error('Application not found', 404);
        }

        if (!$this->applicationModel->isEditable($application['id'])) {
            return $this->error('Application has already been submitted', 403);
        }

        // Verify reCAPTCHA
        if (empty($data['recaptcha_token'])) {
            return $this->error('Please complete the reCAPTCHA verification');
        }

        $recaptcha = new Recaptcha();
        if (!$recaptcha->verify($data['recaptcha_token'], $this->getClientIp())) {
            return $this->error('reCAPTCHA verification failed. Please try again.');
        }

        // Validate step 3 data
        $data = $this->validator->sanitize($data);

        if (!$this->validator->validateStep3($data)) {
            return $this->validationError($this->validator->getErrors());
        }

        // Verify all steps are complete
        $completeData = $this->applicationModel->getCompleteData($application['id']);

        if (!$completeData['student']) {
            return $this->error('Please complete Step 1 (Personal Information) first', 400);
        }

        if (empty($completeData['parents'])) {
            return $this->error('Please complete Step 2 (Parent Details) first', 400);
        }

        try {
            $this->db->beginTransaction();

            // Submit application
            $this->applicationModel->submit(
                $application['id'],
                (bool) ($data['is_existing_student'] ?? false),
                true
            );

            // Log action
            $this->applicationModel->logAction(
                $application['id'],
                'submitted',
                [],
                $this->getClientIp()
            );

            $this->db->commit();

            // Send confirmation email
            try {
                $this->sendConfirmationEmail($application['id']);
            } catch (\Exception $e) {
                error_log('Email sending failed: ' . $e->getMessage());
                // Don't fail the submission if email fails
            }

            return $this->success([
                'application_id' => $application['application_id'],
                'status'         => 'submitted',
            ], 'Application submitted successfully! A confirmation email has been sent.');

        } catch (\Exception $e) {
            $this->db->rollback();
            error_log('Error submitting application: ' . $e->getMessage());
            return $this->error('Failed to submit application. Please try again.');
        }
    }

    /**
     * Save as draft (any step)
     * POST /api/application/{token}/draft
     */
    public function saveDraft(string $token, array $data): array
    {
        $application = $this->applicationModel->findByToken($token);

        if (!$application) {
            return $this->error('Application not found', 404);
        }

        if (!$this->applicationModel->isEditable($application['id'])) {
            return $this->error('Application has already been submitted', 403);
        }

        $step = (int) ($data['step'] ?? 1);
        $formData = $data['form_data'] ?? [];

        // Sanitize data
        $formData = $this->validator->sanitize($formData);
        $formData = $this->validator->decode($formData);

        try {
            if ($step === 1 && !empty($formData)) {
                $this->studentModel->upsert($application['id'], $formData);
            } elseif ($step === 2 && !empty($formData)) {
                $this->parentModel->saveAll($application['id'], $formData);
            }

            return $this->success([
                'token' => $token,
            ], 'Draft saved successfully');

        } catch (\Exception $e) {
            error_log('Error saving draft: ' . $e->getMessage());
            return $this->error('Failed to save draft. Please try again.');
        }
    }

    /**
     * Reset application form
     * POST /api/application/{token}/reset
     */
    public function resetApplication(string $token): array
    {
        $application = $this->applicationModel->findByToken($token);

        if (!$application) {
            return $this->error('Application not found', 404);
        }

        if (!$this->applicationModel->isEditable($application['id'])) {
            return $this->error('Application has already been submitted', 403);
        }

        try {
            $this->db->beginTransaction();

            // Delete student and parent data
            $this->studentModel->delete($application['id']);
            $this->parentModel->deleteByApplicationId($application['id']);

            // Reset step
            $this->applicationModel->updateStep($application['id'], 1);

            // Log action
            $this->applicationModel->logAction(
                $application['id'],
                'reset',
                [],
                $this->getClientIp()
            );

            $this->db->commit();

            return $this->success([
                'current_step' => 1,
            ], 'Form reset successfully');

        } catch (\Exception $e) {
            $this->db->rollback();
            error_log('Error resetting application: ' . $e->getMessage());
            return $this->error('Failed to reset form. Please try again.');
        }
    }

    /**
     * Send confirmation email
     */
    private function sendConfirmationEmail(int $applicationId): bool
    {
        $data = $this->applicationModel->getCompleteData($applicationId);

        if (!$data || !$data['student']) {
            return false;
        }

        $mailer = new Mailer();
        return $mailer->sendConfirmation(
            $data['student']['parent_email'],
            $data['application']['application_id'],
            $data
        );
    }

    /**
     * Get client IP address
     */
    private function getClientIp(): string
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return '0.0.0.0';
    }

    // ========================================
    // Response helpers
    // ========================================

    private function success(array $data, string $message = ''): array
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
            'errors'  => [],
        ];
    }

    private function error(string $message, int $code = 400): array
    {
        http_response_code($code);
        return [
            'success' => false,
            'data'    => null,
            'message' => $message,
            'errors'  => [],
        ];
    }

    private function validationError(array $errors): array
    {
        http_response_code(422);
        return [
            'success' => false,
            'data'    => null,
            'message' => 'Validation failed',
            'errors'  => $errors,
        ];
    }
}
