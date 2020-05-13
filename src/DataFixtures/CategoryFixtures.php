<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $categories = [
            "Ecologie",
            "Loisir",
            "Santé"
        ];

        foreach ($categories as $category){
        $c = new Category();
        $c->setLabel($category);
        $manager->persist($c);
        $this->addReference("cat-" . strtolower($category), $c);
        }
        $manager->flush();
    }
}
