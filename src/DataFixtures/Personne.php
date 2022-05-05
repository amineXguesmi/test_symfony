<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Personne extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
       for ($i=0;$i<40;$i++){
           $persone= new \App\Entity\Personne();
           $persone->setName($faker->name);
           $persone->setAge($faker->numberBetween(18,40));
           $persone->setFirstname($faker->firstName);
           $manager->persist($persone);
       }

        $manager->flush();
    }
}
