<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager, ): void
    {
        for ($i = 0; $i < 500; $i++) {
            $user = new User();
            $user->setEmail('mail'. $i . "@gmail.com");
            $user->setPseudonyme('pseudo-'. $i);
            $user->setPassword('azertyuiop');
            $user->setCoach('1');
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
