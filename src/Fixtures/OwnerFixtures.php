<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Define\BaseOwner;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class OwnerFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
//region SECTION: Fields
    protected static array $data = [
        ['brief' => 'ipc', 'description' => 'ипц'],
        ['brief' => 'zapzap', 'description' => 'зап'],
        ['brief' => 'ite', 'description' => 'ите'],
        ['brief' => 'ng', 'description' => 'новая'],
        ['brief' => 'c2m', 'description' => 'центр'],
        ['brief' => 'spb', 'description' => 'питер'],
    ];

    protected static string $class = BaseOwner::class;
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
            FixtureInterface::BIND_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 1;
    }
}