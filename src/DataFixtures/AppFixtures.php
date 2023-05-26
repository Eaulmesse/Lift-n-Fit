<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Conseil;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $date = new \DateTime();

        for ($i = 0; $i < 500; $i++) {
            $conseil = new Conseil();
            $conseil->setName($i);
            $conseil->setContent($i);
            $conseil->setDate($date);
            $conseil->setUser(null);

            $user = new User();
            $user->setEmail('mail'. $i . "@gmail.com");
            $user->setPseudonyme('pseudo-'. $i);
            $user->setPassword('azertyuiop');
            $user->setCoach('1');
            
            $manager->persist($user);
            $manager->persist($conseil);
        }



        $manager->flush();




    }
}

