<?php


namespace Evrinoma\CodeBundle\Dto\Preserve;


use Evrinoma\CodeBundle\Dto\OwnerApiDto;
use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;

interface CodeApiDtoInterface extends IdInterface, ActiveInterface, DescriptionInterface, BriefInterface
{
//region SECTION: Dto
    /**
     * @param OwnerApiDto $ownerApiDto
     *
     * @return DtoInterface
     */
    public function setOwnerApiDto(OwnerApiDto $ownerApiDto): DtoInterface;

    /**
     * @param TypeApiDto $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(TypeApiDto $typeApiDto): DtoInterface;
//endregion SECTION: Dto
}