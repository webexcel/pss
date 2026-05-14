<?php

declare(strict_types=1);

namespace Api\Models;

use Api\Config\Database;

/**
 * Parent Model
 *
 * Handles all database operations for the parents table (Step 2 data)
 * Named ParentModel to avoid conflict with PHP's parent keyword
 */
class ParentModel
{
    private Database $db;
    private string $table = 'parents';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Save all parent/guardian data for an application
     */
    public function saveAll(int $applicationId, array $data): bool
    {
        // Delete existing records first
        $this->deleteByApplicationId($applicationId);

        // Insert father data
        if (!empty($data['father'])) {
            $this->create($applicationId, 'father', $data['father']);
        }

        // Insert mother data
        if (!empty($data['mother'])) {
            $this->create($applicationId, 'mother', $data['mother']);
        }

        // Insert guardian data if enabled
        if (!empty($data['guardian_enabled']) && !empty($data['guardian'])) {
            $this->create($applicationId, 'guardian', $data['guardian']);
        }

        return true;
    }

    /**
     * Create a parent/guardian record
     */
    public function create(int $applicationId, string $parentType, array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (
                    application_id, parent_type, full_name, qualification,
                    occupation, annual_income, office_address
                ) VALUES (
                    :application_id, :parent_type, :full_name, :qualification,
                    :occupation, :annual_income, :office_address
                )";

        $this->db->execute($sql, [
            'application_id' => $applicationId,
            'parent_type'    => $parentType,
            'full_name'      => $data['full_name'] ?? null,
            'qualification'  => $data['qualification'] ?? null,
            'occupation'     => $data['occupation'] ?? null,
            'annual_income'  => $this->parseIncome($data['annual_income'] ?? null),
            'office_address' => $data['office_address'] ?? null,
        ]);

        return true;
    }

    /**
     * Update a parent/guardian record
     */
    public function update(int $applicationId, string $parentType, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET
                    full_name = :full_name,
                    qualification = :qualification,
                    occupation = :occupation,
                    annual_income = :annual_income,
                    office_address = :office_address
                WHERE application_id = :application_id AND parent_type = :parent_type";

        $this->db->execute($sql, [
            'application_id' => $applicationId,
            'parent_type'    => $parentType,
            'full_name'      => $data['full_name'] ?? null,
            'qualification'  => $data['qualification'] ?? null,
            'occupation'     => $data['occupation'] ?? null,
            'annual_income'  => $this->parseIncome($data['annual_income'] ?? null),
            'office_address' => $data['office_address'] ?? null,
        ]);

        return true;
    }

    /**
     * Find all parents/guardians by application ID
     */
    public function findByApplicationId(int $applicationId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE application_id = :application_id ORDER BY
                CASE parent_type
                    WHEN 'father' THEN 1
                    WHEN 'mother' THEN 2
                    WHEN 'guardian' THEN 3
                END";

        return $this->db->fetchAll($sql, ['application_id' => $applicationId]);
    }

    /**
     * Find parent by type
     */
    public function findByType(int $applicationId, string $parentType): ?array
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE application_id = :application_id AND parent_type = :parent_type
                LIMIT 1";

        return $this->db->fetchOne($sql, [
            'application_id' => $applicationId,
            'parent_type'    => $parentType,
        ]);
    }

    /**
     * Delete all parents/guardians for an application
     */
    public function deleteByApplicationId(int $applicationId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE application_id = :application_id";
        $this->db->execute($sql, ['application_id' => $applicationId]);
        return true;
    }

    /**
     * Delete specific parent type
     */
    public function deleteByType(int $applicationId, string $parentType): bool
    {
        $sql = "DELETE FROM {$this->table}
                WHERE application_id = :application_id AND parent_type = :parent_type";
        $this->db->execute($sql, [
            'application_id' => $applicationId,
            'parent_type'    => $parentType,
        ]);
        return true;
    }

    /**
     * Parse income value to decimal
     */
    private function parseIncome($income): ?float
    {
        if ($income === null || $income === '') {
            return null;
        }
        return (float) preg_replace('/[^0-9.]/', '', (string) $income);
    }

    /**
     * Get formatted parent data for review
     */
    public function getFormattedData(int $applicationId): array
    {
        $parents = $this->findByApplicationId($applicationId);
        $result = [
            'father'   => null,
            'mother'   => null,
            'guardian' => null,
        ];

        foreach ($parents as $parent) {
            $result[$parent['parent_type']] = $parent;
        }

        return $result;
    }
}
