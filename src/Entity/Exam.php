<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(repositoryClass: ExamRepository::class)]
class Exam
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public readonly UuidV7 $id;

    #[ORM\Column(length: 255)]
    private string $name {
        get => $this->name;
        set(string $value) {
            if ('' === trim($value)) {
                throw new \InvalidArgumentException('Exam name cannot be empty.');
            }
            $this->name = $value;
        }
    }

    public function __construct(
        string $name,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        public \DateTimeImmutable $createDt,
        #[ORM\Column(type: Types::TEXT, nullable: true)]
        public ?string $description = null,
    ) {
        $this->id = new UuidV7();
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
