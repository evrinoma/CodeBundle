<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Define\BaseType;

final class TypeFixtures extends Fixture implements FixtureGroupInterface
{
//region SECTION: Fields
    private array $data = [
        ['brief' => 'draft'],
        ['brief' => 'doc'],
        ['brief' => 'xls',],
        ['brief' => 'pdf'],
        ['brief' => 'gost'],
        ['brief' => 'sys'],
    ];
//endregion Fields

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->createTypes($manager);

        $manager->flush();
    }
//endregion Public
//endregion Public

//region SECTION: Private
    private function createTypes(ObjectManager $manager)
    {
        $short = (new \ReflectionClass(BaseType::class))->getShortName()."_";
        $i     = 0;

        foreach ($this->data as $record) {
            $entity = new BaseType();
            $entity->setBrief($record['brief']);
            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            $i++;
        }

        return $this;
    }

//endregion Private

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return [
            FixtureInterface::BIND_FIXTURES
        ];
    }
}