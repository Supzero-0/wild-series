<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const SERIES = [
        ['title' => 'Walking dead', 'synopsis' => 'Des zombies envahissent la terre', 'category' => 'category_Action'],
        ['title' => 'Mercredi', 'synopsis' => 'La famille Adams de retour', 'category' => 'category_Fantastique'],
        ['title' => 'Cyberpunk Edgerunner', 'synopsis' => 'Des humains modifiés se battent pour survivre', 'category' => 'category_Animation'],
        ['title' => 'Rick et Morty', 'synopsis' => 'Un grand-père savant fou avec sa famille loufoque', 'category' => 'category_Animation'],
        ['title' => 'JoJo\'s Bizarre Adeventure', 'synopsis' => 'Muda muda muda muda muda', 'category' => 'category_Animation'],
        ['title' => 'The 100', 'synopsis' => 'Des humains survivent sur une Terre dévasté par la pollution', 'category' => 'category_Aventure'],
        ['title' => 'Resident Evil', 'synopsis' => 'Un virus tueur, l\'humanité en péril', 'category' => 'category_Horreur'],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach (self::SERIES as $key => $values) {
            $program = new Program();
            $program->setTitle($values['title']);
            $program->setSynopsis($values['synopsis']);
            $program->setCategory($this->getReference($values['category']));
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
