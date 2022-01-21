<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Bind\BaseBind;
use Evrinoma\CodeBundle\Entity\Bunch\BaseBunch;
use Evrinoma\CodeBundle\Entity\Code\BaseCode;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class BindFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
//region SECTION: Fields
    protected static array $data = [
        ['bunch' => 0, 'code' => 8, 'active' => 'a'],
        ['bunch' => 0, 'code' => 1, 'active' => 'a'],
        ['bunch' => 0, 'code' => 2, 'active' => 'a'],

        ['bunch' => 1, 'code' => 3, 'active' => 'a'],

        ['bunch' => 2, 'code' => 0, 'active' => 'a'],

        ['bunch' => 3, 'code' => 4, 'active' => 'a'],
        ['bunch' => 3, 'code' => 5, 'active' => 'd'],
        ['bunch' => 3, 'code' => 6, 'active' => 'd'],

        ['bunch' => 5, 'code' => 7, 'active' => 'd'],
    ];

    protected static string $class = BaseBind::class;
//endregion Fields

//region SECTION: Private
    /**
     * @param ObjectManager $manager
     *
     * @return $this
     */
    protected function create(ObjectManager $manager): self
    {
        $short      = (new \ReflectionClass(BaseBind::class))->getShortName()."_";
        $shortBunch = (new \ReflectionClass(BaseBunch::class))->getShortName()."_";
        $shortCode  = (new \ReflectionClass(BaseCode::class))->getShortName()."_";
        $i          = 0;

        foreach (static::$data as $record) {
            $entity = new BaseBind();
            $entity
                ->setBunch($this->getReference($shortBunch.$record['bunch']))
                ->setCode($this->getReference($shortCode.$record['code']))
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
            FixtureInterface::BIND_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 1000;
    }
}