<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Entity\BaseBunch;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeCreatedException;
use Evrinoma\CodeBundle\Manager\Type\QueryManagerInterface;
use Evrinoma\CodeBundle\Model\BunchInterface;

class BunchFactory implements BunchFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseBunch::class;

    private QueryManagerInterface $queryManager;
//endregion Fields

//region SECTION: Constructor
    public function __construct(QueryManagerInterface $queryManager)
    {
        $this->queryManager = $queryManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchCannotBeCreatedException
     */
    public function create(BunchApiDtoInterface $dto): BunchInterface
    {
        /** @var BaseBunch $bunch */
        $bunch = new self::$entityClass;

        try {
            $type = $this->queryManager->proxy($dto->getTypeApiDto());
        } catch (\Exception $e) {
            throw new BunchCannotBeCreatedException($e->getMessage());
        }

        $bunch
            ->setDescription($dto->getDescription())
            ->setType($type)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $bunch;
    }
//endregion Public
}