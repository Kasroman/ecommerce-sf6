<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@admin.com');
        $admin->setLastName('admin');
        $admin->setFirstName('admin');
        $admin->setAddress('12 rue de ta maman');
        $admin->setZipcode('34000');
        $admin->setCity('Montpellier');
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <=5; $usr++){
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastName($faker->lastname);
            $user->setFirstName($faker->firstname);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ', '',$faker->postcode));
            $user->setCity($faker->city);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'user'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
