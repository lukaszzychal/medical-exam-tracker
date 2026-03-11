<?php

namespace App\Tests\Entity;

use App\Entity\Exam;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV7;

class ExamTest extends TestCase
{
    public function testExamCanBeCreatedWithRequiredFields(): void
    {
        $now = new \DateTimeImmutable();
        $exam = new Exam('Blood Chemistry', $now);

        $this->assertSame('Blood Chemistry', $exam->getName());
        $this->assertSame($now, $exam->getCreateDt());
        $this->assertInstanceOf(UuidV7::class, $exam->getId());
    }

    public function testExamIdIsGeneratedAutomaticallyOnCreation(): void
    {
        $examA = new Exam('CBC', new \DateTimeImmutable());
        $examB = new Exam('Urinalysis', new \DateTimeImmutable());

        $this->assertNotEquals($examA->getId(), $examB->getId());
    }

    public function testExamDescriptionIsNullableByDefault(): void
    {
        $exam = new Exam('Urinalysis', new \DateTimeImmutable());

        $this->assertNull($exam->getDescription());
    }

    public function testExamDescriptionCanBeSet(): void
    {
        $exam = new Exam('Complete Blood Count', new \DateTimeImmutable());
        $exam->setDescription('Full blood panel analysis');

        $this->assertSame('Full blood panel analysis', $exam->getDescription());
    }

    public function testExamNameCannotBeEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Exam('', new \DateTimeImmutable());
    }

    public function testExamNameCannotBeUpdatedToEmpty(): void
    {
        $exam = new Exam('CBC', new \DateTimeImmutable());

        $this->expectException(\InvalidArgumentException::class);
        $exam->setName('');
    }
}
