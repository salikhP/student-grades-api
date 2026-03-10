<?php
declare(strict_types=1);
namespace App\Controller;

use App\Service\GradeAccessService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class GradeController extends AbstractController
{
    #[Route('/api/grades/by-token', name: 'api_grades_by_token', methods: ['POST'])]
    public function byToken(Request $request, GradeAccessService $gradeAccessService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data) || !isset($data['token']) || !is_string($data['token'])) {
            return $this->json([
                'error' => 'Token is required'
            ], 400);
        }

        $token = $data['token'];

        $result = $gradeAccessService->getGradesByToken($token);

        if (!$result) {
            return $this->json([
                'error' => 'Student not found'
            ], 404);
        }

        return $this->json($result);
    }
}
