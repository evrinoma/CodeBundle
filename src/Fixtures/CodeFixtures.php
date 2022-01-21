<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Code\BaseCode;
use Evrinoma\CodeBundle\Entity\Define\BaseOwner;
use Evrinoma\CodeBundle\Entity\Define\BaseType;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class CodeFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{

//region SECTION: Fields
    protected static array $data = [
        ['brief' => 'CM', 'description' => 'smeta', 'type' => 0, 'owner' => 0, 'active' => 'a'], //0
        ['brief' => 'RD', 'description' => 'adasdad', 'type' => 0, 'owner' => 1, 'active' => 'a'], //1
        ['brief' => 'KD', 'description' => 'sdfsdf', 'type' => 0, 'owner' => 1, 'active' => 'a'], //2
        ['brief' => 'KD2', 'description' => 'sdfsdf2', 'type' => 0, 'owner' => 1, 'active' => 'a'], //3
        ['brief' => 'SP', 'description' => 'sadasd', 'type' => 1, 'owner' => 0, 'active' => 'a'], //4
        ['brief' => 'KJ', 'description' => 'adsdasd', 'type' => 1, 'owner' => 0, 'active' => 'a'], //5
        ['brief' => 'KJ2', 'description' => 'adsdasd2', 'type' => 1, 'owner' => 1, 'active' => 'a'], //6
        ['brief' => 'QW', 'description' => 'rtyrty', 'type' => 2, 'owner' => 0, 'active' => 'd'], //7
        ['brief' => 'XXX', 'description' => 'xxxxx', 'type' => 0, 'owner' => 0, 'active' => 'a'], //8
    ];

    protected static string $class = BaseCode::class;
//endregion Fields

//region SECTION: Private
    /**
     * @param ObjectManager $manager
     *
     * @return $this
     */
    protected function create(ObjectManager $manager): self
    {
        $short      = self::getReferenceName();
        $shortType  = TypeFixtures::getReferenceName();
        $shortOwner = OwnerFixtures::getReferenceName();
        $i          = 0;

        foreach (static::$data as $record) {
            $entity = new BaseCode();
            $entity
                ->setCreatedAt(new \DateTimeImmutable())
                ->setActive($record['active'])
                ->setBrief($record['brief'])
                ->setDescription($record['description'])
                ->setType($this->getReference($shortType.$record['type']))
                ->setOwner($this->getReference($shortOwner.$record['owner']));
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

    public function getDependencies()
    {
        return [
            FixtureInterface::TYPE_FIXTURES,
            FixtureInterface::OWNER_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 100;
    }
}