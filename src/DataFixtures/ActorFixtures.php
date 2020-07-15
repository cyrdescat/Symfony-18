<?php

namespace App\DataFixtures;

use App\Service\Slugify;
use Faker;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();
        $faker = Faker\Factory::create('fr_FR');
        $i = 0;
        while ($i < 50) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference("program_4"));
            $slug = $slugify->generate($actor->getName());
            $actor->setSlug($slug);
            $manager->persist($actor);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}