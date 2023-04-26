<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Project();
            $product->setName('project '.$i);
            $product->setDescription('Projetc'.$i);
            $product->setPrice(mt_rand(1000, 10000));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
