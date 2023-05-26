<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($count = 0; $count < 20; $count++) {
            $article = new Article();
            $article->setTitle("Titre " . $count);
            $article->setUri("Uri Fixture" . $count);
            $manager->persist($article);
        }
        $manager->flush();
    }
}

