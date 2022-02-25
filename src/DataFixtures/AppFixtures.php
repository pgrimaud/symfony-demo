<?php

namespace App\DataFixtures;

use App\Entity\Pet;
use App\Entity\PetCategory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // generate 10 users
        // assigner aléatoirement un user à un pet
        // 1 chance sur 2 que le pet n'est pas de user
        // un utilisteur peut avoir plusieurs pets

        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setEmail('test' . $i . '@test.com');
            $user->setFirstName('Pierre ' . $i);
            $user->setLastName('Grimaud');

            if($i === 1){
                $user->setRoles([
                    'ROLE_ADMIN'
                ]);
            }

            $password = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);

            $manager->persist($user);
            $users[] = $user;
        }

        $manager->flush();

        // generate 3 categories (Cat, Dog, Mosquito)
        // generate 10 pets per category
        foreach (['Cat', 'Dog', 'Mosquito'] as $name) {
            $petCategory = new PetCategory;
            $petCategory->setName($name);

            $manager->persist($petCategory);

            for ($i = 1; $i <= 10; $i++) {
                $pet = new Pet;
                $pet->setName($petCategory->getName() . ' ' . $i);
                $pet->setPetCategory($petCategory);

                if (rand(0, 1) === 0) {
                    $pet->setUser($users[rand(0, count($users) - 1)]);
                }

                $manager->persist($pet);
            }

            $manager->flush();
        }
    }
}
