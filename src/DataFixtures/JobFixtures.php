<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
        for ($i=0;$i<40;$i++){
            $job= new \App\Entity\Job();
            $job->setType($faker->dayOfWeek);
            $manager->persist($job);
        }
        $manager->flush();
    }
}
