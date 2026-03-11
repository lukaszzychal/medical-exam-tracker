<?php

namespace App\Entity;

use App\Repository\ParameterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(repositoryClass: ParameterRepository::class)]
class Parameter
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV7 $id;

    #[ORM\Column(length: 255)]
    private string $name;

    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'parameters')]
        #[ORM\JoinColumn(nullable: false)]
        private readonly Exam $exam,
        string $name,
        #[ORM\Column]
        private float $value,
    ) {
        $this->id = new UuidV7();
        $this->setName($name);
        $exam->addParameter($this);
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getExam(): Exam
    {
        return $this->exam;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        if ('' === trim($name)) {
            throw new \InvalidArgumentException('Parameter name cannot be empty.');
        }

        $this->name = $name;

        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }
}
