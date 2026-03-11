<?php

namespace App\Controller;

use App\Entity\Exam;
use App\Repository\ExamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExamController extends AbstractController
{
    #[Route('/', name: 'app_exam_index', methods: ['GET'])]
    public function index(ExamRepository $examRepository): Response
    {
        $exams = $examRepository->findBy([], ['createDt' => 'DESC']);

        return $this->render('exam/index.html.twig', [
            'exams' => $exams,
        ]);
    }

    #[Route('/exam/{id}', name: 'app_exam_show', methods: ['GET'])]
    public function show(Exam $exam): Response
    {
        return $this->render('exam/show.html.twig', [
            'exam' => $exam,
        ]);
    }
}
