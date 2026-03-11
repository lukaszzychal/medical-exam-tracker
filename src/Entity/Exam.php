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
    private UuidV7 $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createDt;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct(string $name, \DateTimeImmutable $createDt)
    {
        $this->id = new UuidV7();
        $this->setName($name);
        $this->createDt = $createDt;
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        if ('' === trim($name)) {
            throw new \InvalidArgumentException('Exam name cannot be empty.');
        }

        $this->name = $name;

        return $this;
    }

    public function getCreateDt(): \DateTimeImmutable
    {
        return $this->createDt;
    }

    public function setCreateDt(\DateTimeImmutable $createDt): static
    {
        $this->createDt = $createDt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
