<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Painting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $paintings = $manager->getRepository(Painting::class)->findAll();
        $countPaints = count($paintings);
        $faker = Faker\Factory::create();
        for ($i = 1; $i <= 15; $i++) {
            $comment = new Comment();
            $comment->setName($faker->userName())
                ->setPainting($paintings[$faker->numberBetween(0, $countPaints - 1)])
                ->setComment($faker->paragraph(1,true))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setIsPublished(true);

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PaintingFixtures::class
        ];
    }
}
