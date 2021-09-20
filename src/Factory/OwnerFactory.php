<?php
namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Entity\BaseOwner;
use Evrinoma\CodeBundle\Model\OwnerInterface;

final class OwnerFactory implements OwnerFactoryInterface
{
    private static string $entityClass = BaseOwner::class;

    public function create(OwnerApiDtoInterface $dto): OwnerInterface
    {
        /** @var BaseOwner $contractor */
        $contractor = new self::$entityClass;

        $contractor
            ->setBrief($dto->getBrief())
            ->setDescription($dto->getDescription());

        return $contractor;
    }
}