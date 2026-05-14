<?php

declare(strict_types=1);

namespace Api\Models;

use Api\Config\Database;

/**
 * Application Model
 *
 * Handles all database operations for the applications table
 */
class Application
{
    private Database $db;
    private string $table = 'applications';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Create a new application (without application_id - generated on submission)
     */
    public function create(string $ipAddress, string $userAgent): array
    {
        // Generate secure token
        $token = bin2hex(random_bytes(32));

        $sql = "INSERT INTO {$this->table}
                (token, status, current_step, ip_address, user_agent)
                VALUES (:token, 'draft', 1, :ip_address, :user_agent)";

        $this->db->execute($sql, [
            'token'          => $token,
            'ip_address'     => $ipAddress,
            'user_agent'     => substr($userAgent, 0, 255),
        ]);

        $id = (int) $this->db->lastInsertId();

        // Log the action
        $this->logAction($id, 'created', ['ip' => $ipAddress]);

        return [
            'id'             => $id,
            'application_id' => null, // Will be generated on submission
            'token'          => $token,
        ];
    }

    /**
     * Generate application ID on submission
     */
    public function generateApplicationId(int $id): string
    {
        // Generate unique application ID
        $stmt = $this->db->getConnection()->prepare('CALL generate_application_id(@app_id)');
        $stmt->execute();
        $result = $this->db->fetchOne('SELECT @app_id as application_id');
        $applicationId = $result['application_id'];

        // Update the application with the generated ID
        $sql = "UPDATE {$this->table} SET application_id = :application_id WHERE id = :id";
        $this->db->execute($sql, [
            'application_id' => $applicationId,
            'id'             => $id,
        ]);

        return $applicationId;
    }

    /**
     * Find application by token
     */
    public function findByToken(string $token): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE token = :token LIMIT 1";
        return $this->db->fetchOne($sql, ['token' => $token]);
    }

    /**
     * Find application by ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }

    /**
     * Find application by application_id (public ID)
     */
    public function findByApplicationId(string $applicationId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE application_id = :application_id LIMIT 1";
        return $this->db->fetchOne($sql, ['application_id' => $applicationId]);
    }

    /**
     * Update application step
     */
    public function updateStep(int $id, int $step): bool
    {
        $sql = "UPDATE {$this->table} SET current_step = :step WHERE id = :id";
        $this->db->execute($sql, ['step' => $step, 'id' => $id]);
        return true;
    }

    /**
     * Update application status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $validStatuses = ['draft', 'submitted', 'confirmed'];
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Invalid status');
        }

        $sql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $this->db->execute($sql, ['status' => $status, 'id' => $id]);
        return true;
    }

    /**
     * Submit the application
     */
    public function submit(int $id, bool $isExistingStudent, bool $termsAccepted): bool
    {
        $sql = "UPDATE {$this->table}
                SET status = 'submitted',
                    is_existing_student = :is_existing_student,
                    terms_accepted = :terms_accepted,
                    submitted_at = NOW()
                WHERE id = :id";

        $this->db->execute($sql, [
            'id'                  => $id,
            'is_existing_student' => $isExistingStudent ? 1 : 0,
            'terms_accepted'      => $termsAccepted ? 1 : 0,
        ]);

        $this->logAction($id, 'submitted', []);

        return true;
    }

    /**
     * Get complete application data with student and parent details
     */
    public function getCompleteData(int $id): ?array
    {
        $application = $this->findById($id);
        if (!$application) {
            return null;
        }

        // Get student data
        $studentModel = new Student();
        $student = $studentModel->findByApplicationId($id);

        // Get parent data
        $parentModel = new ParentModel();
        $parents = $parentModel->findByApplicationId($id);

        return [
            'application' => $application,
            'student'     => $student,
            'parents'     => $parents,
        ];
    }

    /**
     * Log application action
     */
    public function logAction(int $applicationId, string $action, array $details, ?string $ipAddress = null): void
    {
        $sql = "INSERT INTO application_logs (application_id, action, details, ip_address)
                VALUES (:application_id, :action, :details, :ip_address)";

        $this->db->execute($sql, [
            'application_id' => $applicationId,
            'action'         => $action,
            'details'        => json_encode($details),
            'ip_address'     => $ipAddress,
        ]);
    }

    /**
     * Check if application is still editable (draft status)
     */
    public function isEditable(int $id): bool
    {
        $application = $this->findById($id);
        return $application && $application['status'] === 'draft';
    }

    /**
     * Delete draft applications older than specified days
     */
    public function cleanupOldDrafts(int $days = 7): int
    {
        $sql = "DELETE FROM {$this->table}
                WHERE status = 'draft'
                AND created_at < DATE_SUB(NOW(), INTERVAL :days DAY)";

        $stmt = $this->db->execute($sql, ['days' => $days]);
        return $stmt->rowCount();
    }

}
