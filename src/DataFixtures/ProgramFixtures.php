<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Notre planète',
        'Peaky Blinders',
        'Vikings',
        'Dans leur regard',
        'Stranger Things',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $programTitle) { 
            $program = new Program();     
            $program->setTitle($programTitle);    
            $program->setSummary('Voici le résumé de la série ' . $programTitle);    
            $program->setCategory($this->getReference('category_' . $key));
            $this->addReference('program_' . $key, $program);
            for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
                $program->addActor($this->getReference('actor_' . $i));
            $manager->persist($program);
            }
        }  
        
        
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
	
    
          


