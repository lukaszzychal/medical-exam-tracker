<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /** @var Collection<int, Parameter> */
    #[ORM\OneToMany(targetEntity: Parameter::class, mappedBy: 'exam', cascade: ['persist', 'remove'])]
    private Collection $parameters;

    public function __construct(
        string $name,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private \DateTimeImmutable $createDt,
        #[ORM\Column(type: Types::TEXT, nullable: true)]
        private ?string $description = null,
    ) {
        $this->id = new UuidV7();
        $this->setName($name);
        $this->parameters = new ArrayCollection();
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

    /** @return Collection<int, Parameter> */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }

    public function addParameter(Parameter $parameter): void
    {
        if (!$this->parameters->contains($parameter)) {
            $this->parameters->add($parameter);
        }
    }
}
