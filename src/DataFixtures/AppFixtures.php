<?php

namespace App\DataFixtures;

use App\Entity\Exam;
use App\Entity\Parameter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $exam1 = new Exam('Basic Blood Test', new \DateTimeImmutable('-2 days'), 'Standard yearly checkup');
        $manager->persist($exam1);

        $manager->persist(new Parameter($exam1, 'Leukocytes', 6.2));
        $manager->persist(new Parameter($exam1, 'Erythrocytes', 4.8));
        $manager->persist(new Parameter($exam1, 'Hemoglobin', 14.5));

        $exam2 = new Exam('Thyroid Profile', new \DateTimeImmutable('-1 week'));
        $manager->persist($exam2);

        $manager->persist(new Parameter($exam2, 'TSH', 1.8));
        $manager->persist(new Parameter($exam2, 'FT3', 4.1));
        $manager->persist(new Parameter($exam2, 'FT4', 15.2));

        $manager->flush();
    }
}
