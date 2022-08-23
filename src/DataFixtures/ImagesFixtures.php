<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        
        for($img = 1; $img <= 100; $img++){
            $image = new Images();
            $imgPath = $faker->imageUrl(null, 640, 480);
            $image->setName($imgPath);
            
            $product = $this->getReference('prod-' . rand(1, 20));
            $image->setProducts($product);
            $manager->persist($image);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProductsFixtures::class];
    }
}
