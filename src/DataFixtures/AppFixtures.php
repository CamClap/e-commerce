<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\client;
use App\Entity\Vendeur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }
    public function load(ObjectManager $manager): void
    {
        require_once 'vendor/autoload.php';

        $faker = Factory::create();
        for ($i = 0; $i < 3; $i++) {
            $vendeur = new Vendeur();
            $vendeur->setEmail($faker->email());
            $vendeur->setRoles(["ROLE_VENDEUR"]);
            $vendeur->setPassword($this->passwordHasher->hashPassword($vendeur, "vendeur"));
            $vendeur->setNom($faker->name());
            $vendeur->setPrenom($faker->firstName());
            $client = new Client();
            $client->setEmail($faker->email());
            $client->setRoles(["ROLE_CLIENT"]);
            $client->setPassword($this->passwordHasher->hashPassword($client, "client"));
            $client->setNom($faker->name());
            $client->setPrenom($faker->firstName());
            $manager->persist($client);
            $manager->persist($vendeur);
            $manager->flush();
        }
       
      
    }
}
