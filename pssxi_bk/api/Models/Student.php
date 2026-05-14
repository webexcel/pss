<?php

declare(strict_types=1);

namespace Api\Models;

use Api\Config\Database;

/**
 * Student Model
 *
 * Handles all database operations for the students table (Step 1 data)
 */
class Student
{
    private Database $db;
    private string $table = 'students';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Create or update student record
     */
    public function upsert(int $applicationId, array $data): bool
    {
        $existing = $this->findByApplicationId($applicationId);

        if ($existing) {
            return $this->update($applicationId, $data);
        }

        return $this->create($applicationId, $data);
    }

    /**
     * Create a new student record
     */
    public function create(int $applicationId, array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (
                    application_id, full_name, gender, date_of_birth, class_applying,
                    community, emis_number, father_mobile, mother_mobile, parent_email,
                    residential_address, previous_school, maths_type,
                    subject_pref_1, subject_pref_2, subject_pref_3, subject_pref_4, integrated_course
                ) VALUES (
                    :application_id, :full_name, :gender, :date_of_birth, :class_applying,
                    :community, :emis_number, :father_mobile, :mother_mobile, :parent_email,
                    :residential_address, :previous_school, :maths_type,
                    :subject_pref_1, :subject_pref_2, :subject_pref_3, :subject_pref_4, :integrated_course
                )";

        $this->db->execute($sql, $this->prepareData($applicationId, $data));
        return true;
    }

    /**
     * Update existing student record
     */
    public function update(int $applicationId, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET
                    full_name = :full_name,
                    gender = :gender,
                    date_of_birth = :date_of_birth,
                    class_applying = :class_applying,
                    community = :community,
                    emis_number = :emis_number,
                    father_mobile = :father_mobile,
                    mother_mobile = :mother_mobile,
                    parent_email = :parent_email,
                    residential_address = :residential_address,
                    previous_school = :previous_school,
                    maths_type = :maths_type,
                    subject_pref_1 = :subject_pref_1,
                    subject_pref_2 = :subject_pref_2,
                    subject_pref_3 = :subject_pref_3,
                    subject_pref_4 = :subject_pref_4,
                    integrated_course = :integrated_course
                WHERE application_id = :application_id";

        $this->db->execute($sql, $this->prepareData($applicationId, $data));
        return true;
    }

    /**
     * Find student by application ID
     */
    public function findByApplicationId(int $applicationId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE application_id = :application_id LIMIT 1";
        return $this->db->fetchOne($sql, ['application_id' => $applicationId]);
    }

    /**
     * Delete student record
     */
    public function delete(int $applicationId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE application_id = :application_id";
        $this->db->execute($sql, ['application_id' => $applicationId]);
        return true;
    }

    /**
     * Prepare data for database insertion
     */
    private function prepareData(int $applicationId, array $data): array
    {
        return [
            'application_id'      => $applicationId,
            'full_name'           => $data['full_name'] ?? null,
            'gender'              => $data['gender'] ?? null,
            'date_of_birth'       => $data['date_of_birth'] ?? null,
            'class_applying'      => $data['class_applying'] ?? null,
            'community'           => $data['community'] ?? null,
            'emis_number'         => $data['emis_number'] ?? null,
            'father_mobile'       => $data['father_mobile'] ?? null,
            'mother_mobile'       => $data['mother_mobile'] ?? null,
            'parent_email'        => $data['parent_email'] ?? null,
            'residential_address' => $data['residential_address'] ?? null,
            'previous_school'     => $data['previous_school'] ?? null,
            'maths_type'          => $data['maths_type'] ?? null,
            'subject_pref_1'      => $data['subject_pref_1'] ?? null,
            'subject_pref_2'      => $data['subject_pref_2'] ?? null,
            'subject_pref_3'      => $data['subject_pref_3'] ?? null,
            'subject_pref_4'      => $data['subject_pref_4'] ?? null,
            'integrated_course'   => $data['integrated_course'] ?? 'No',
        ];
    }
}
