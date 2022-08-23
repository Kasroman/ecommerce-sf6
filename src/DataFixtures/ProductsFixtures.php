<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductsFixtures extends Fixture
{
    private $words = [];

    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($prod = 1; $prod <= 20; $prod++){
            $product = new Products();

            $name = $faker->word(10);
            while(in_array($name, $this->words)){
                $name = $faker->word(10);
            }
            $product->setName($name);
            $this->words[] = $name;

            $product->setDescription($faker->text());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(100, 150000));
            $product->setStock($faker->numberBetween(0, 10));
            $category = $this->getReference('cat-' . rand(1, 6));
            $product->setCategories($category);
            $manager->persist($product);
            $this->addReference('prod-' . $prod, $product);
        }
        $this->words = [];

        $manager->flush();
    }
}
