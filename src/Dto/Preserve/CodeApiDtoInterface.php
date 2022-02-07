<?php


namespace Evrinoma\CodeBundle\Dto\Preserve;


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
     * @param OwnerApiDtoInterface $ownerApiDto
     *
     * @return DtoInterface
     */
    public function setOwnerApiDto(OwnerApiDtoInterface $ownerApiDto): DtoInterface;

    /**
     * @param TypeApiDtoInterface $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(TypeApiDtoInterface $typeApiDto): DtoInterface;
//endregion SECTION: Dto
}