<?php

namespace App\Tests\Entity;

use App\Entity\Exam;
use App\Entity\Parameter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV7;

class ParameterTest extends TestCase
{
    private Exam $exam;

    protected function setUp(): void
    {
        $this->exam = new Exam('Blood Chemistry', new \DateTimeImmutable());
    }

    public function testParameterCanBeCreatedWithRequiredFields(): void
    {
        $parameter = new Parameter($this->exam, 'Iron', 12.5);

        $this->assertSame('Iron', $parameter->name);
        $this->assertSame(12.5, $parameter->value);
        $this->assertInstanceOf(UuidV7::class, $parameter->id);
    }

    public function testParameterIdIsGeneratedAutomaticallyOnCreation(): void
    {
        $parameterA = new Parameter($this->exam, 'Iron', 12.5);
        $parameterB = new Parameter($this->exam, 'Calcium', 9.5);

        $this->assertNotEquals($parameterA->id, $parameterB->id);
    }

    public function testParameterBelongsToExam(): void
    {
        $parameter = new Parameter($this->exam, 'Iron', 12.5);

        $this->assertSame($this->exam, $parameter->exam);
    }

    public function testExamCollectsAddedParameters(): void
    {
        $parameterA = new Parameter($this->exam, 'Iron', 12.5);
        $parameterB = new Parameter($this->exam, 'Calcium', 9.5);

        $parameters = $this->exam->getParameters();

        $this->assertCount(2, $parameters);
        $this->assertTrue($parameters->contains($parameterA));
        $this->assertTrue($parameters->contains($parameterB));
    }

    public function testParameterNameCannotBeEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Parameter($this->exam, '', 12.5);
    }
}
