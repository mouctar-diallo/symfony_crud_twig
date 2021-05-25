<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=2; $i < 15; $i++) { 
            $article = (new Article())
                     ->setTitre("titre n°$i")
                     ->setDescription("description n°$i")
                     ->setCreatedAt(new \DateTime());

            $manager->persist($article);
        }
        $manager->flush();
    }
}
