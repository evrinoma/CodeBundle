<?php


namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface as BaseOwnerApiDtoInterface;
use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface as BaseTypeApiDtoInterface;
use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;

interface CodeApiDtoInterface extends IdInterface, ActiveInterface, DescriptionInterface, BriefInterface
{
//region SECTION: Dto
    /**
     * @param BaseOwnerApiDtoInterface $ownerApiDto
     *
     * @return DtoInterface
     */
    public function setOwnerApiDto(BaseOwnerApiDtoInterface $ownerApiDto): DtoInterface;

    /**
     * @param BaseTypeApiDtoInterface $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(BaseTypeApiDtoInterface $typeApiDto): DtoInterface;
//endregion SECTION: Dto
}