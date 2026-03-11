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
    public readonly UuidV7 $id;

    #[ORM\Column(length: 255)]
    public string $name {
        set(string $value) {
            if ('' === trim($value)) {
                throw new \InvalidArgumentException('Parameter name cannot be empty.');
            }
            $this->name = $value;
        }
    }

    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'parameters')]
        #[ORM\JoinColumn(nullable: false)]
        public readonly Exam $exam,
        string $name,
        #[ORM\Column]
        public float $value,
    ) {
        $this->id = new UuidV7();
        $this->name = $name;
        $exam->addParameter($this);
    }
}
