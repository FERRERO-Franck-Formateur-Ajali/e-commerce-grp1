<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Comment;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");

        for($i = 1; $i <= 50; $i++){
            $randomprice = random_int(1, 30);
            $randomstock = (bool)random_int(0, 1);
            $promo = [true, false];
            shuffle($promo);
            $promo = true === $promo[0] ? rand(1, 20) : null;

            $produit = new Produit();
            $produit->setName($faker->sentence(rand(3, 10), true))
                    ->setContent($faker->text(rand(100, 150)))
                    ->setDetails($faker->text(rand(100, 2000)))
                    ->setImage($faker->imageUrl(800, 600, 'food'))
                    ->setPrice("$randomprice")
                    ->setStock("$randomstock")
                    ->setPromo($promo);

            $manager->persist($produit);

            for ($k = 1; $k <= mt_rand(0, 5); $k++){
                $comment = new Comment();

                $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTime())
                        ->setProduit($produit);
                
                $manager->persist($comment);
                        
            }
        }

        $manager->flush();
    }
}
