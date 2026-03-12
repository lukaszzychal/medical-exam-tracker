<?php

namespace App\Service;

use App\Entity\Exam;
use App\Entity\Parameter;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

readonly class ParameterManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @param array{name: string, value: float} $data
     */
    public function addParameterToExam(Exam $exam, array $data): Parameter
    {
        $parameter = new Parameter(
            $exam,
            $data['name'],
            $data['value']
        );

        $this->entityManager->persist($parameter);
        $this->entityManager->flush();

        $this->logger->info('New parameter added to exam via ParameterManager', [
            'exam_id' => $exam->getId()->toRfc4122(),
            'parameter_id' => $parameter->getId()->toRfc4122(),
            'parameter_name' => $parameter->getName(),
            'parameter_value' => $parameter->getValue(),
        ]);

        return $parameter;
    }
}
