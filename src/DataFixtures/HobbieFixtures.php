<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HobbieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
        for ($i=0;$i<40;$i++){
            $hobbie= new \App\Entity\Hobbie();
            $hobbie->setDeseniation($faker->city);

            $manager->persist($hobbie);
        }

        $manager->flush();
    }
}
