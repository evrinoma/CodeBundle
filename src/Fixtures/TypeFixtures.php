<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Define\BaseType;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class TypeFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
//region SECTION: Fields
    protected static array $data = [
        ['brief' => 'draft'],
        ['brief' => 'doc'],
        ['brief' => 'xls',],
        ['brief' => 'pdf'],
        ['brief' => 'gost'],
        ['brief' => 'sys'],
    ];

    protected static string $class = BaseType::class;
//endregion Fields

//region SECTION: Private
    /**
     * @param ObjectManager $manager
     *
     * @return $this
     */
    protected function create(ObjectManager $manager): self
    {
        $short = self::getReferenceName();
        $i     = 0;

        foreach (static::$data as $record) {
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
            FixtureInterface::BIND_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}