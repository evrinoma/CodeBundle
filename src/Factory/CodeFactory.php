<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Entity\Code\BaseCode;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;

class CodeFactory implements CodeFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseCode::class;
//endregion Fields

//region SECTION: Constructor
    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     */
    public function create(CodeApiDtoInterface $dto): CodeInterface
    {
        /** @var BaseCode $bunch */
        $bunch = new self::$entityClass;

        $bunch
            ->setBrief($dto->getBrief())
            ->setDescription($dto->getDescription())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $bunch;
    }
//endregion Public
}