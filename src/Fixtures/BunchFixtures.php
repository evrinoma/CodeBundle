<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Bunch\BaseBunch;
use Evrinoma\CodeBundle\Entity\Define\BaseType;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class BunchFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{

//region SECTION: Fields
    protected static array $data = [
        ['description' => 'calc estimate', 'type' => 0, 'active' => 'a'], //0
        ['description' => 'system', 'type' => 0, 'active' => 'a'], //1
        ['description' => 'career', 'type' => 0, 'active' => 'a'], //2
        ['description' => 'work doc', 'type' => 1, 'active' => 'a'], //3
        ['description' => 'job', 'type' => 1, 'active' => 'a'], //4
        ['description' => 'lib', 'type' => 2, 'active' => 'd'], //5
    ];

    protected static string $class = BaseBunch::class;
//endregion Fields

//region SECTION: Private
    /**
     * @param ObjectManager $manager
     *
     * @return $this
     */
    protected function create(ObjectManager $manager):self
    {
        $short      = self::getReferenceName();
        $shortType  = TypeFixtures::getReferenceName();
        $i         = 0;

        foreach (static::$data as $record) {
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