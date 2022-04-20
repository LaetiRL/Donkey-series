<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        $program = new Program();
        $program->setTitle("The Walking Dead");
        $program->setSummary("L'histoire suit le personnage de Rick Grimes, adjoint du shérif. Il se réveille d'un coma de plusieurs semaines pour découvrir que la population a été ravagée par une épidémie inconnue qui transforme les êtres humains en morts-vivants. Avec un groupe de rescapé, ils sont amenés à devoir survivre dans un monde post-apocalyptique.");
        $program->setPoster("https://m.media-amazon.com/images/I/71loVl64+NL._AC_SL1000_.jpg");
        $program->setCategory($this->getReference('category_4'));
        $program->addActor($this->getReference(ActorFixtures::ACTORS[6]));
        $program->addActor($this->getReference(ActorFixtures::ACTORS[7]));
        $program->addActor($this->getReference(ActorFixtures::ACTORS[8]));
        

        $manager->persist($program);
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
        ];
    }
}
