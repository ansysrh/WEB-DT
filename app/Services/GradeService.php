<?php

namespace App\Services;

class GradeService
{
    public function calculateGrade(int $score)
    {
        if ($score < 0 || $score > 100) {
            return 'INVALID';
        }
        if ($score >= 85) {
            return 'A';
        }
        if ($score >= 70) {
            return 'B';
        }
        return 'C';
    }
}
