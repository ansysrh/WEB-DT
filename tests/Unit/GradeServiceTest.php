<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\GradeService;

class GradeServiceTest extends TestCase
{
    public function test_it_returns_invalid_for_invalid_scores()
    {
        $service = new GradeService();

        $this->assertEquals('INVALID', $service->calculateGrade(-1));
        $this->assertEquals('INVALID', $service->calculateGrade(101));
    }

    public function test_it_returns_grade_A_for_high_scores()
    {
        $service = new GradeService();

        $this->assertEquals('A', $service->calculateGrade(85));
        $this->assertEquals('A', $service->calculateGrade(95));
    }

    public function test_it_returns_grade_B_for_medium_scores()
    {
        $service = new GradeService();

        $this->assertEquals('B', $service->calculateGrade(70));
        $this->assertEquals('B', $service->calculateGrade(80));
    }

    public function test_it_returns_grade_C_for_low_scores()
    {
        $service = new GradeService();

        $this->assertEquals('C', $service->calculateGrade(69));
        $this->assertEquals('C', $service->calculateGrade(50));
    }
}
