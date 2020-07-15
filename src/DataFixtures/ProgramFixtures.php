<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();
        $i = 0;
        while ($i < 15) {
            $program = new Program();
            $program->setTitle("Program $i");
            $program->setCountry("Country $i");
            $program->setSummary("summary $i");
            $program->setPoster("poster $i");
            $program->setYear(2000 + $i);
            $program->setCategory($this->getReference('category_7'));
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $manager->persist($program);
            $this->addReference("program_$i", $program);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}