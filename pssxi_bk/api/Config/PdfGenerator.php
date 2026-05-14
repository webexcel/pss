<?php

declare(strict_types=1);

namespace Api\Config;

// Load FPDF and FPDI
require_once __DIR__ . '/../../libs/fpdf.php';
require_once __DIR__ . '/../../libs/fpdi/autoload.php';

use setasign\Fpdi\Fpdi;

/**
 * PDF Generator for Admission Application
 *
 * Fills the Class XI application PDF template with student data
 */
class PdfGenerator extends Fpdi
{
    private string $templatePath;

    // Field positions (X, Y coordinates in mm) for Page 1
    // A4 page is 210mm x 297mm
    // Positioned just above dotted lines with 2mm left spacing
    private array $page1Fields = [
        // Web No. box (inside the box on right side)
        'web_no'            => ['x' => 174, 'y' => 83],

        // Basic Information section - each field on its own dotted line
        'student_name'      => ['x' => 84, 'y' => 104],
        'date_of_birth'     => ['x' => 84, 'y' => 116],
        'gender'            => ['x' => 84, 'y' => 127],
        'address'           => ['x' => 14, 'y' => 149, 'multiline' => true, 'width' => 150],
        'community'         => ['x' => 88, 'y' => 187],
        'emis_number'       => ['x' => 88, 'y' => 205],
        'maths_type'        => ['x' => 88, 'y' => 223],
        'previous_school'   => ['x' => 88, 'y' => 244],
        'integrated_course' => ['x' => 88, 'y' => 263],
    ];

    // Field positions for Page 2 - Parent Details Table
    // Positioned just above dotted lines with 2mm left spacing
    private array $page2Fields = [
        // Father column (2mm from left edge of cell)
        'father_name'           => ['x' => 73, 'y' => 47],
        'father_qualification'  => ['x' => 73, 'y' => 61],
        'father_occupation'     => ['x' => 73, 'y' => 76, 'multiline' => true, 'width' => 48],
        'father_mobile'         => ['x' => 73, 'y' => 93],
        'father_email'          => ['x' => 73, 'y' => 107],
        'father_income'         => ['x' => 73, 'y' => 123],

        // Mother column (2mm from left edge of cell)
        'mother_name'           => ['x' => 134, 'y' => 47],
        'mother_qualification'  => ['x' => 134, 'y' => 61],
        'mother_occupation'     => ['x' => 134, 'y' => 76, 'multiline' => true, 'width' => 48],
        'mother_mobile'         => ['x' => 134, 'y' => 93],
        'mother_email'          => ['x' => 134, 'y' => 107],
        'mother_income'         => ['x' => 134, 'y' => 123],

        // Subject Preferences table (2mm from left edge)
        'preference_1'          => ['x' => 57, 'y' => 163],
        'preference_2'          => ['x' => 57, 'y' => 178],
        'preference_3'          => ['x' => 57, 'y' => 191],
        'preference_4'          => ['x' => 57, 'y' => 205],

        // Date and Place at bottom
        'date'                  => ['x' => 25, 'y' => 268],
        'place'                 => ['x' => 92, 'y' => 268],
    ];

    // Subject group labels
    private array $subjectGroups = [
        'group1' => 'Group I: Maths, Physics, Chemistry, Biology',
        'group2' => 'Group II: Maths, Physics, Chemistry, Computer Science',
        'group3' => 'Group III: Physics, Chemistry, Botany, Zoology',
        'group4' => 'Group IV: Accountancy, Commerce, Economics, Computer Applications',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->templatePath = __DIR__ . '/../../Class XI-2026-27.pdf';
    }

    /**
     * Generate filled PDF for an application
     */
    public function generate(array $data): string
    {
        // Set document properties
        $this->SetAuthor('P.S. Senior Secondary School');
        $this->SetTitle('Admission Application - ' . ($data['application']['application_id'] ?? ''));

        // Import and fill Page 1
        $this->addTemplatePage(1);
        $this->fillPage1($data);

        // Import and fill Page 2
        $this->addTemplatePage(2);
        $this->fillPage2($data);

        // Return PDF as string
        return $this->Output('S');
    }

    /**
     * Add a page from the template
     */
    private function addTemplatePage(int $pageNo): void
    {
        $this->AddPage();
        $this->setSourceFile($this->templatePath);
        $templateId = $this->importPage($pageNo);
        $this->useTemplate($templateId, 0, 0, 210, 297); // A4 size
    }

    /**
     * Fill Page 1 - Basic Information
     */
    private function fillPage1(array $data): void
    {
        $student = $data['student'] ?? [];
        $application = $data['application'] ?? [];

        $this->SetFont('Helvetica', '', 10);
        $this->SetTextColor(0, 0, 0);

        // Web No. (Application ID)
        $this->writeField('web_no', $application['application_id'] ?? '', $this->page1Fields, 9);

        // Student Name
        $this->writeField('student_name', strtoupper($student['full_name'] ?? ''), $this->page1Fields);

        // Date of Birth (format: DD/MM/YYYY)
        $dob = $student['date_of_birth'] ?? '';
        if ($dob) {
            $dob = date('d/m/Y', strtotime($dob));
        }
        $this->writeField('date_of_birth', $dob, $this->page1Fields);

        // Gender
        $this->writeField('gender', ucfirst($student['gender'] ?? ''), $this->page1Fields);

        // Address (multiline)
        $this->writeMultilineField('address', $student['residential_address'] ?? '', $this->page1Fields);

        // Community
        $community = $student['community'] ?? '';
        if ($community && $community !== 'General') {
            $this->writeField('community', strtoupper($community), $this->page1Fields);
        } else {
            $this->writeField('community', 'General', $this->page1Fields);
        }

        // EMIS Number
        $this->writeField('emis_number', $student['emis_number'] ?? '', $this->page1Fields);

        // Maths Type
        $mathsType = $student['maths_type'] ?? '';
        if ($mathsType) {
            $mathsType = $mathsType === 'basic' ? 'Basic Maths' : 'Standard Maths';
        }
        $this->writeField('maths_type', $mathsType, $this->page1Fields);

        // Previous School
        $this->writeField('previous_school', $student['previous_school'] ?? '', $this->page1Fields);

        // Integrated Course
        $this->writeField('integrated_course', $student['integrated_course'] ?? 'No', $this->page1Fields);
    }

    /**
     * Fill Page 2 - Parent Details & Preferences
     */
    private function fillPage2(array $data): void
    {
        $parents = $data['parents'] ?? [];
        $student = $data['student'] ?? [];

        // Organize parents by type
        $father = [];
        $mother = [];
        foreach ($parents as $parent) {
            if ($parent['parent_type'] === 'father') {
                $father = $parent;
            } elseif ($parent['parent_type'] === 'mother') {
                $mother = $parent;
            }
        }

        $this->SetFont('Helvetica', '', 9);
        $this->SetTextColor(0, 0, 0);

        // Father Details
        $this->writeField('father_name', strtoupper($father['full_name'] ?? ''), $this->page2Fields);
        $this->writeField('father_qualification', $this->formatQualification($father['qualification'] ?? ''), $this->page2Fields);
        $this->writeMultilineField('father_occupation', $this->formatOccupation($father), $this->page2Fields);
        $this->writeField('father_mobile', $student['father_mobile'] ?? '', $this->page2Fields);
        $this->writeField('father_email', $student['parent_email'] ?? '', $this->page2Fields);
        $this->writeField('father_income', $this->formatIncome($father['annual_income'] ?? ''), $this->page2Fields);

        // Mother Details
        $this->writeField('mother_name', strtoupper($mother['full_name'] ?? ''), $this->page2Fields);
        $this->writeField('mother_qualification', $this->formatQualification($mother['qualification'] ?? ''), $this->page2Fields);
        $this->writeMultilineField('mother_occupation', $this->formatOccupation($mother), $this->page2Fields);
        $this->writeField('mother_mobile', $student['mother_mobile'] ?? '', $this->page2Fields);
        $this->writeField('mother_email', '', $this->page2Fields); // Only one email captured
        $this->writeField('mother_income', $this->formatIncome($mother['annual_income'] ?? ''), $this->page2Fields);

        // Subject Preferences (database columns are subject_pref_1, etc.)
        $this->writeField('preference_1', $this->getSubjectLabel($student['subject_pref_1'] ?? ''), $this->page2Fields);
        $this->writeField('preference_2', $this->getSubjectLabel($student['subject_pref_2'] ?? ''), $this->page2Fields);
        $this->writeField('preference_3', $this->getSubjectLabel($student['subject_pref_3'] ?? ''), $this->page2Fields);
        $this->writeField('preference_4', $this->getSubjectLabel($student['subject_pref_4'] ?? ''), $this->page2Fields);

        // Date and Place
        $this->writeField('date', date('d/m/Y'), $this->page2Fields);
        $this->writeField('place', 'Chennai', $this->page2Fields);
    }

    /**
     * Write a single field at specified position
     */
    private function writeField(string $fieldName, string $value, array $fields, int $fontSize = 10): void
    {
        if (!isset($fields[$fieldName]) || empty($value)) {
            return;
        }

        $field = $fields[$fieldName];
        $this->SetFont('Helvetica', '', $fontSize);
        $this->SetXY($field['x'], $field['y']);
        $this->Cell(0, 5, $this->cleanText($value), 0, 0, 'L');
    }

    /**
     * Write a multiline field
     */
    private function writeMultilineField(string $fieldName, string $value, array $fields): void
    {
        if (!isset($fields[$fieldName]) || empty($value)) {
            return;
        }

        $field = $fields[$fieldName];
        $width = $field['width'] ?? 100;

        $this->SetFont('Helvetica', '', 9);
        $this->SetXY($field['x'], $field['y']);
        $this->MultiCell($width, 15, $this->cleanText($value), 0, 'L');
    }

    /**
     * Clean text for PDF output
     */
    private function cleanText(string $text): string
    {
        // Convert to ISO-8859-1 for FPDF compatibility
        $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
        // Remove any problematic characters
        $text = preg_replace('/[^\x20-\x7E\xA0-\xFF]/', '', $text);
        return trim($text);
    }

    /**
     * Format qualification for display
     */
    private function formatQualification(string $qualification): string
    {
        $labels = [
            'high_school'   => 'High School',
            'undergraduate' => 'Undergraduate',
            'postgraduate'  => 'Postgraduate',
            'doctorate'     => 'Doctorate',
            'other'         => 'Other',
        ];

        return $labels[$qualification] ?? ucfirst($qualification);
    }

    /**
     * Format occupation with office address
     */
    private function formatOccupation(array $parent): string
    {
        $occupation = $parent['occupation'] ?? '';
        $address = $parent['office_address'] ?? '';

        if ($occupation && $address) {
            return $occupation . ', ' . $address;
        }

        return $occupation ?: $address;
    }

    /**
     * Format income for display
     */
    private function formatIncome($income): string
    {
        if (empty($income)) {
            return '';
        }

        $amount = floatval($income);
        if ($amount > 0) {
            return 'Rs. ' . number_format($amount, 0, '.', ',');
        }

        return '';
    }

    /**
     * Get subject group label
     */
    private function getSubjectLabel(string $groupKey): string
    {
        if (empty($groupKey)) {
            return '';
        }

        return $this->subjectGroups[$groupKey] ?? ucfirst(str_replace('_', ' ', $groupKey));
    }

    /**
     * Output PDF to browser for download
     */
    public function download(array $data, string $filename = ''): void
    {
        if (empty($filename)) {
            $appId = $data['application']['application_id'] ?? 'application';
            $filename = 'Application_' . $appId . '.pdf';
        }

        // Generate PDF
        $this->generate($data);

        // Output for download
        $this->Output('D', $filename);
    }

    /**
     * Output PDF to browser for inline viewing
     */
    public function view(array $data, string $filename = ''): void
    {
        if (empty($filename)) {
            $appId = $data['application']['application_id'] ?? 'application';
            $filename = 'Application_' . $appId . '.pdf';
        }

        // Generate PDF
        $this->generate($data);

        // Output for inline viewing
        $this->Output('I', $filename);
    }
}
