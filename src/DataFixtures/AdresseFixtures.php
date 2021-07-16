<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\AdresseFacturation;
use App\Entity\AdresseLivraison;

class AdresseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");

        for($j = 1; $j <= mt_rand(2, 8); $j++){

            $adresselivraison = new AdresseLivraison();
            $adresselivraison->setNom($faker->firstName)
                            ->setprenom($faker->lastName) 
                            ->setAdresse($faker->streetAddress)
                            ->setCp($faker->postcode)
                            ->setVille($faker->city)
                            ->settelephone($faker->phoneNumber);

            $manager->persist($adresselivraison);
            $manager->flush();

            for($l = 1; $l <= mt_rand(2, 8); $l++){

                $adressefacturation = new AdresseFacturation();
                $adressefacturation->setNom($faker->firstName)
                                    ->setprenom($faker->lastName) 
                                    ->setAdresse($faker->streetAddress)
                                    ->setCp($faker->postcode)
                                    ->setVille($faker->city)
                                    ->settelephone($faker->phoneNumber);
    
                $manager->persist($adressefacturation);
                $manager->flush();
        
            }

        }
    }
}

