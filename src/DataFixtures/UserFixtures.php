<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    
        $faker = Factory::create("fr_FR");

        for($u = 1; $u <= 25; $u++){

            $user = new User();
            $user->setNom($faker->firstName)
                ->setprenom($faker->lastName) 
                ->setEmail($faker->streetAddress)
                ->setpassword($faker->postcode)
                ->setBirthday($faker->date($format = 'd-m-Y', $max = 'now'))
                ->setphone($faker->phoneNumber);

            $manager->persist($user);
            $manager->flush();

        }
        
    }
}