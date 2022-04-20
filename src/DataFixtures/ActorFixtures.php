<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    const ACTORS = [
        'Sarah Paulson',
        'Evan Peter',
        'Jessica Lange',
        'Hailee Steinfeld',
        'Ella Purnell',
        'Katie Leung',
        'Andrew Lincoln',
        'Norman Reedus',
        'Steven Yeun',
    ];
    
    public function load(ObjectManager $manager): void
    {
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $manager->persist($actor);
            $this->addReference(self::ACTORS[$key], $actor);
        }
        $manager->flush();
    }
}
