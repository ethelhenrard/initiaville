<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $boite = new Project();
        $boite->setTitle("Boîte à livres");
        $boite->setPicture("boite-a-lire.jpg");
        $boite->setExcerpt("Permettre l'échange de livre entre particuliers.");
        $boite->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto, corporis enim inventore iure laudantium minus nam odio officia quae quasi quia repellat reprehenderit, tempora tempore, temporibus ullam ut voluptates.');
        $boite->setCity($this->getReference("city-rennes"));
        $boite->addCategory($this->getReference("cat-ecologie"));
        $boite->addCategory($this->getReference("cat-loisir"));
        $boite->setUser($this->getReference("user-pjehan"));
        $boite->setCost("3000");
        $manager->persist($boite);
        $this->addReference("pj-boite", $boite);

        $potager = new Project();
        $potager->setTitle("Potager sur les toits");
        $potager->setPicture("potager-toit.jpg");
        $potager->setExcerpt("Aménager des potagers sur les toits de la ville.");
        $potager->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto, corporis enim inventore iure laudantium minus nam odio officia quae quasi quia repellat reprehenderit, tempora tempore, temporibus ullam ut voluptates.');
        $potager->setCity($this->getReference("city-rennes"));
        $potager->addCategory($this->getReference("cat-ecologie"));
        $potager->setUser($this->getReference("user-jdupont"));
        $potager->setCost("75000");
        $manager->persist($potager);
        $this->addReference("pj-potager", $potager);

        $cine = new Project();
        $cine->setTitle("Cinéma en plein air");
        $cine->setPicture("cinema-plein-air.jpg");
        $cine->setExcerpt("Proposer des séances de cinéma en plein 2 soirs par semaine.");
        $cine->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto, corporis enim inventore iure laudantium minus nam odio officia quae quasi quia repellat reprehenderit, tempora tempore, temporibus ullam ut voluptates.');
        $cine->setCity($this->getReference("city-stmalo"));
        $cine->addCategory($this->getReference("cat-loisir"));
        $cine->setUser($this->getReference("user-jdupont"));
        $cine->setCost("25000");
        $this->addReference("pj-cine", $cine);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class,
            CityFixtures::class,
            UserFixtures::class,

        ];
    }
}
