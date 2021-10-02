<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Define\BaseOwner;

final class OwnerFixtures extends Fixture implements FixtureGroupInterface, OrderedFixtureInterface
{
//region SECTION: Fields
    private array $data = [
        ['brief' => 'ipc', 'description' => 'ипц'],
        ['brief' => 'zapzap', 'description' => 'зап'],
        ['brief' => 'ite', 'description' => 'ите'],
        ['brief' => 'ng', 'description' => 'новая'],
        ['brief' => 'c2m', 'description' => 'центр'],
        ['brief' => 'spb', 'description' => 'питер'],
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

//region SECTION: Private
    private function createTypes(ObjectManager $manager)
    {
        $short = (new \ReflectionClass(BaseOwner::class))->getShortName()."_";
        $i     = 0;

        foreach ($this->data as $record) {
            $entity = new BaseOwner();
            $entity->setBrief($record['brief'])->setDescription($record['description']);
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

    public function getOrder()
    {
        return 1;
    }
}