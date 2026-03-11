<?php

namespace App\Tests\Controller;

use App\Entity\Exam;
use App\Entity\Parameter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExamControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->entityManager = self::getContainer()->get('doctrine')->getManager();
    }

    public function testIndexDisplaysExamsAndReturns200(): void
    {
        $exam = new Exam('Blood Test', new \DateTimeImmutable('2023-01-01'), 'Routine check');
        $this->entityManager->persist($exam);
        $this->entityManager->flush();

        $this->client->request('GET', '/');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'Medical Exams');
        $this->assertSelectorTextContains('body', 'Blood Test');
    }

    public function testShowDisplaysExamDetailsAndReturns200(): void
    {
        $exam = new Exam('X-Ray Test', new \DateTimeImmutable('2023-02-01'));
        $parameter = new Parameter($exam, 'Radiation Level', 1.5);

        $this->entityManager->persist($exam);
        $this->entityManager->persist($parameter);
        $this->entityManager->flush();

        $this->client->request('GET', '/exam/'.$exam->getId());

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'Exam Details');
        $this->assertSelectorTextContains('body', 'X-Ray Test');
        $this->assertSelectorTextContains('body', 'Radiation Level');
        $this->assertSelectorTextContains('body', '1.5');
    }
}
