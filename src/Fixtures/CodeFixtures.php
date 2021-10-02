<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Code\BaseCode;
use Evrinoma\CodeBundle\Entity\Define\BaseOwner;
use Evrinoma\CodeBundle\Entity\Define\BaseType;

class CodeFixtures extends Fixture implements FixtureGroupInterface
{

//region SECTION: Fields
    private array $data = [
        ['brief' => 'CM', 'description' => 'smeta', 'type' => 1, 'owner' => 2, 'active' => 'a'],
        ['brief' => 'KJ', 'description' => 'adsdasd', 'type' => 2, 'owner' => 1, 'active' => 'a'],
        ['brief' => 'RD', 'description' => 'adasdad', 'type' => 1, 'owner' => 2, 'active' => 'a'],
        ['brief' => 'SP', 'description' => 'sadasd', 'type' => 2, 'owner' => 1, 'active' => 'a'],
        ['brief' => 'KD', 'description' => 'sdfsdf', 'type' => 1, 'owner' => 2, 'active' => 'a'],
        ['brief' => 'QW', 'description' => 'rtyrty', 'type' => 3, 'owner' => 1, 'active' => 'd'],
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

        $short      = (new \ReflectionClass(BaseCode::class))->getShortName()."_";
        $shortType  = (new \ReflectionClass(BaseType::class))->getShortName()."_";
        $shortOwner = (new \ReflectionClass(BaseOwner::class))->getShortName()."_";
        $i          = 0;

        foreach ($this->data as $record) {
            $entity = new BaseCode();
            $entity
                ->setCreatedAt(new \DateTimeImmutable())
                ->setActive($record['active'])
                ->setBrief($record['brief'])
                ->setDescription($record['description'])
                ->setType($this->getReference($shortType.$record['type']))
                ->setOwner($this->getReference($shortOwner.$record['owner']));
            $this->addReference($short.'_'.$i, $entity);
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
            FixtureInterface::TYPE_FIXTURES,
            FixtureInterface::OWNER_FIXTURES,
        ];
    }
}