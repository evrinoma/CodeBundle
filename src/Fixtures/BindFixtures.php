<?php

namespace Evrinoma\CodeBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Entity\Bind\BaseBind;
use Evrinoma\CodeBundle\Entity\Bunch\BaseBunch;
use Evrinoma\CodeBundle\Entity\Code\BaseCode;

class BindFixtures extends Fixture implements FixtureGroupInterface
{

//region SECTION: Fields
    private array $data = [
        ['bunch' => 0, 'code' => 0, 'active' => 'a'],
        ['bunch' => 0, 'code' => 1, 'active' => 'a'],
        ['bunch' => 0, 'code' => 2, 'active' => 'a'],

        ['bunch' => 1, 'code' => 3, 'active' => 'a'],

        ['bunch' => 2, 'code' => 0, 'active' => 'a'],

        ['bunch' => 3, 'code' => 4, 'active' => 'a'],
        ['bunch' => 3, 'code' => 5, 'active' => 'd'],
        ['bunch' => 3, 'code' => 6, 'active' => 'd'],

        ['bunch' => 5, 'code' => 7, 'active' => 'd'],
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

        $short      = (new \ReflectionClass(BaseBind::class))->getShortName()."_";
        $shortBunch = (new \ReflectionClass(BaseBunch::class))->getShortName()."_";
        $shortCode  = (new \ReflectionClass(BaseCode::class))->getShortName()."_";
        $i          = 0;

        foreach ($this->data as $record) {
            $entity = new BaseBind();
            $entity
                ->setBunch($this->getReference($shortBunch.$record['bunch']))
                ->setCode($this->getReference($shortCode.$record['code']))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setActive($record['active']);

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
            FixtureInterface::CODE_FIXTURES,
            FixtureInterface::BUNCH_FIXTURES,
        ];
    }
}