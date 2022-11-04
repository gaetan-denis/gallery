<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private array $categories=['Baroque', ' Renaissance italienne','	
Âge d\'or de la peinture néerlandaise,','Surréalisme', 'Impressionnisme', 'Art Abstrait'];
    public function load(ObjectManager $manager): void

    {
        foreach($this->categories as $category){
            $cat= new Category();
            $cat->setName($category);
            $manager->persist($cat);
        }
        $manager->flush();
    }
}
