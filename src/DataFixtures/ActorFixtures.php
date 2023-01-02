<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $actor = new Actor();
            $actor->setFirstname($faker->firstName());
            $actor->setLastname($faker->lastName());
            $actor->setBirthDate($faker->dateTime());
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, 6)));
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, 6)));
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, 6)));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
