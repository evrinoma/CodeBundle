<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Entity\Bunch\BaseBunch;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;

class BunchFactory implements BunchFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseBunch::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }
//endregion Fields

//region SECTION: Public
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     */
    public function create(BunchApiDtoInterface $dto): BunchInterface
    {
        /** @var BaseBunch $bunch */
        $bunch = new self::$entityClass;

        $bunch
            ->setDescription($dto->getDescription())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $bunch;
    }
//endregion Public
}