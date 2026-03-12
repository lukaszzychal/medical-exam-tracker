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

    public function testAddParameterToExamReturns302AndAddsToDb(): void
    {
        $exam = new Exam('MRI Scan', new \DateTimeImmutable('2023-03-01'));
        $this->entityManager->persist($exam);
        $this->entityManager->flush();

        $crawler = $this->client->request('GET', '/exam/'.$exam->getId());
        $this->assertResponseStatusCodeSame(200);

        // Znajdź formularz po przycisku (może mieć etykietę 'Add Parameter')
        $form = $crawler->selectButton('Add Parameter')->form([
            'parameter[name]' => 'Contrast Volume',
            'parameter[value]' => '10.5',
        ]);

        $this->client->submit($form);

        // Oczekujemy redirect z powrotem na /exam/{id}
        $this->assertResponseRedirects('/exam/'.$exam->getId());

        // Podążamy za przekierowaniem
        $this->client->followRedirect();

        // Sprawdzamy, czy nowy parametr został poprawnie dodany na liście
        $this->assertSelectorTextContains('body', 'Contrast Volume');
        $this->assertSelectorTextContains('body', '10.5');

        // Sprawdzamy czy fizycznie trafił do bazy pod odpowiednim kluczem
        $parameterInDb = $this->entityManager->getRepository(Parameter::class)->findOneBy(['name' => 'Contrast Volume']);
        $this->assertNotNull($parameterInDb);
        $this->assertSame(10.5, $parameterInDb->getValue());
        $this->assertSame($exam->getId()->toRfc4122(), $parameterInDb->getExam()->getId()->toRfc4122());
    }
}
