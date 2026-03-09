<?php
declare(strict_types=1);
namespace App\Service;

use App\Repository\StudentRepository;

class GradeAccessService
{
    public function __construct(
        private StudentRepository $studentRepository,
    ) {
    }

    public function getGradesByToken(string $token): ?array
    {
        $student = $this->studentRepository->findOneBy(['token' => $token]);

        if (!$student) {
            return null;
        }

        $grades = [];

        foreach ($student->getGrades() as $grade) {
            $grades[] = [
                'title' => $grade->getTitle(),
                'score' => $grade->getScore(),
                'type' => $grade->getType(),
            ];
        }

        return [
            'student' => [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
            ],
            'grades' => $grades,
        ];

    }
}
