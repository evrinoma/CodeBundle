<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Entity\Bind\BaseBind;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;

class BindFactory implements BindFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseBind::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }
//endregion Fields

//region SECTION: Public
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     */
    public function create(BindApiDtoInterface $dto): BindInterface
    {
        /** @var BaseBind $bind */
        $bind = new self::$entityClass;

        $bind
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $bind;
    }
//endregion Public
}