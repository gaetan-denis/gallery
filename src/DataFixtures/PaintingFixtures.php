<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Painting;
use App\Entity\Technical;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PaintingFixtures extends Fixture implements DependentFixtureInterface
{
    private array $titles = ['Flowers', 'Souvenir d\'Océanie', 'L\'Annonciation', 'En été, la Bohémienne', 'Le thérapeute', 'Nuit étoilée', 'Le martyre de saint Barthélemy', 'Petit éclat de lueur rose bleue iridescente', 'La Belle Ferronnière
', 'Haven Painting', 'Girl fishing', 'La Jeune Fille à la perle'];

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();
        $technicals = $manager->getRepository(Technical::class)->findAll();
        $countCat = count($categories);
        $countTech = count($technicals);
        $faker = Faker\Factory::create();
        $slugify = new Slugify();
        foreach ($this->titles as $key => $title) {
            $paints = new Painting();
            $paints->setTitre($title)
                ->setDescription($faker->paragraph(3, true))
                ->setCreation($faker->numberBetween(1453, 2022))
                ->setHauteur($faker->numberBetween(50, 200))
                ->setLargeur($faker->numberBetween(50, 200))
                ->setImage('paint' . $key + 1 .'.jpg')
                ->setCategory($categories[$faker->numberBetween(0, $countCat - 1)])
                ->setTechnical($technicals[$faker->numberBetween(0, $countTech - 1)])
                ->setSlug($slugify->slugify($title));
            $manager->persist($paints);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            TechnicalFixtures::class
        ];
    }
}
