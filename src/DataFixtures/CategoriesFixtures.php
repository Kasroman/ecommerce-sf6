<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory($manager, 'Informatique');

        $this->createCategory($manager, 'Ordinateurs Portables', $parent);

        $this->createCategory($manager, 'Ecrans', $parent);

        $peripheriques = $this->createCategory($manager, 'Périphériques', $parent);

        $this->createCategory($manager, 'Souris', $peripheriques);

        $this->createCategory($manager, 'Clavier', $peripheriques);

        $manager->flush();
    }

    public function createCategory(ObjectManager $manager, string $name, Categories $parent = null)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        if($parent){
            $category->setParent($parent);
        }
        $manager->persist($category);

        $this->addReference('cat-' . $this->counter, $category);
        $this->counter++;

        return $category;
    }
}
