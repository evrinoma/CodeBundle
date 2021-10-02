<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Bunch\BaseBunch;
use Evrinoma\CodeBundle\Entity\Define\BaseType;

final class BunchFixtures extends Fixture implements FixtureGroupInterface, OrderedFixtureInterface
{

//region SECTION: Fields
    private array $data = [
        ['description' => 'calc estimate', 'type' => 0, 'active' => 'a'], //0
        ['description' => 'system', 'type' => 0, 'active' => 'a'], //1
        ['description' => 'career', 'type' => 0, 'active' => 'a'], //2
        ['description' => 'work doc', 'type' => 1, 'active' => 'a'], //3
        ['description' => 'job', 'type' => 1, 'active' => 'a'], //4
        ['description' => 'lib', 'type' => 2, 'active' => 'd'], //5
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

        $short     = (new \ReflectionClass(BaseBunch::class))->getShortName()."_";
        $shortType = (new \ReflectionClass(BaseType::class))->getShortName()."_";
        $i         = 0;

        foreach ($this->data as $record) {
            $entity = new BaseBunch();
            $entity
                ->setDescription($record['description'])
                ->setType($this->getReference($shortType.$record['type']))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setActive($record['active']);

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
        return 101;
    }
}