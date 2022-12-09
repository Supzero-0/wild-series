<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 350; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->word());
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setSynopsis($faker->paragraphs(3, true));
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(0, 35)));
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
