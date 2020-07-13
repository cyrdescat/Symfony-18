<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $i = 0;
        while ($i < 8) {
            $category = new Category();
            $category->setName("Category $i");
            $manager->persist($category);
            $this->addReference("category_$i", $category);
            $i++;
        }
        $manager->flush();
    }
}
