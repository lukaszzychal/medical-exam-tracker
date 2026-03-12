<?php

namespace App\Controller;

use App\Entity\Exam;
use App\Repository\ExamRepository;
use App\Service\ParameterManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/exam/{id}', name: 'app_exam_show', methods: ['GET', 'POST'])]
    public function show(
        Exam $exam,
        Request $request,
        ParameterManager $parameterManager,
    ): Response {
        $form = $this->createForm(\App\Form\ParameterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var array{name: string, value: float} $data */
            $data = $form->getData();

            $parameterManager->addParameterToExam($exam, $data);

            return $this->redirectToRoute('app_exam_show', ['id' => $exam->getId()]);
        }

        return $this->render('exam/show.html.twig', [
            'exam' => $exam,
            'form' => $form,
        ]);
    }
}
