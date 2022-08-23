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
        $informatique = $this->createCategory($manager, 'Informatique');

        $this->createCategory($manager, 'Ordinateurs Portables', $informatique);

        $this->createCategory($manager, 'Ecrans', $informatique);

        $this->createCategory($manager, 'Composants', $informatique);

        $this->createCategory($manager, 'Souris', $informatique);

        $vetements = $this->createCategory($manager, 'Vetements');

        $this->createCategory($manager, 'Pantalon', $vetements);

        $this->createCategory($manager, 'Accessoires', $vetements);

        $this->createCategory($manager, 'Hauts', $vetements);

        $this->createCategory($manager, 'Chaussures', $vetements);

        $manager->flush();
    }

    public function createCategory(ObjectManager $manager, string $name, Categories $parent = null)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setCategoryOrder($this->counter);
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
