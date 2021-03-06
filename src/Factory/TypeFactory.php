<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\CodeBundle\Entity\Define\BaseType;
use Evrinoma\CodeBundle\Model\Define\TypeInterface;

final class TypeFactory implements TypeFactoryInterface
{
    private static string $entityClass = BaseType::class;

    public function create(TypeApiDtoInterface $dto): TypeInterface
    {
        /** @var BaseType $type */
        $type = new self::$entityClass;

        $type
            ->setBrief($dto->getBrief());

        return $type;
    }
}