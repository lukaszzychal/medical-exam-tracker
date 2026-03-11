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
    public readonly UuidV7 $id;

    #[ORM\Column(length: 255)]
    public string $name {
        set(string $value) {
            if ('' === trim($value)) {
                throw new \InvalidArgumentException('Exam name cannot be empty.');
            }
            $this->name = $value;
        }
    }

    /** @var Collection<int, Parameter> */
    #[ORM\OneToMany(targetEntity: Parameter::class, mappedBy: 'exam', cascade: ['persist', 'remove'])]
    private Collection $parameters;

    public function __construct(
        string $name,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        public \DateTimeImmutable $createDt,
        #[ORM\Column(type: Types::TEXT, nullable: true)]
        public ?string $description = null,
    ) {
        $this->id = new UuidV7();
        $this->name = $name;
        $this->parameters = new ArrayCollection();
    }

    public function addParameter(Parameter $parameter): void
    {
        if (!$this->parameters->contains($parameter)) {
            $this->parameters->add($parameter);
        }
    }

    /** @return Collection<int, Parameter> */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }
}
