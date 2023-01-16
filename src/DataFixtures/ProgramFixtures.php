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
        ['title' => 'Walking dead', 'synopsis' => 'Des zombies envahissent la terre', 'category' => 'category_Action', 'poster' => 'walkingdead-63bc2b6712685248398224.jpeg'],
        ['title' => 'Mercredi', 'synopsis' => 'La famille Adams de retour', 'category' => 'category_Fantastique', 'poster' => 'mercredi-63bc2b7492ca9106325922.jpeg'],
        ['title' => 'Cyberpunk Edgerunner', 'synopsis' => 'Des humains modifiés se battent pour survivre', 'category' => 'category_Animation', 'poster' => 'cyberpunkedgerunner-63bc2b801abdb637403885.jpeg'],
        ['title' => 'Rick et Morty', 'synopsis' => 'Un grand-père savant fou avec sa famille loufoque', 'category' => 'category_Animation', 'poster' => 'rick-et-morty-63bc2b9bdbc3a782293177.jpeg'],
        ['title' => 'JoJo\'s Bizarre Adeventure', 'synopsis' => 'Muda muda muda muda muda', 'category' => 'category_Animation', 'poster' => 'jojo-s-bizarre-adeventure-63bc2ba399db8608726353.jpeg'],
        ['title' => 'The 100', 'synopsis' => 'Des humains survivent sur une Terre dévasté par la pollution', 'category' => 'category_Aventure', 'poster' => 'the-100-63bc2bb25e430545783543.jpeg'],
        ['title' => 'Resident Evil', 'synopsis' => 'Un virus tueur, l\'humanité en péril', 'category' => 'category_Horreur', 'poster' => 'resident-evil-63bc2bbd5e986499033825.jpeg'],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach (self::SERIES as $key => $values) {
            $program = new Program();
            $program->setTitle($values['title']);
            $program->setSynopsis($values['synopsis']);
            $program->setCategory($this->getReference($values['category']));
            $program->setPoster($values['poster']);
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
