<?php


namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\CodeBundle\Dto\OwnerApiDto;
use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;

trait CodeApiDtoTrait
{
//region SECTION: Dto
    /**
     * @param OwnerApiDto $ownerApiDto
     *
     * @return DtoInterface
     */
    public function setOwnerApiDto(OwnerApiDto $ownerApiDto): DtoInterface
    {
        return parent::setOwnerApiDto($ownerApiDto);
    }

    /**
     * @param TypeApiDto $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(TypeApiDto $typeApiDto): DtoInterface
    {
        return parent::setTypeApiDto($typeApiDto);
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @param string $active
     *
     * @return self|DtoInterface
     */
    public function setActive(string $active): DtoInterface
    {
        return parent::setActive($active);
    }

    /**
     * @param string $description
     *
     * @return DtoInterface
     */
    public function setDescription(string $description): DtoInterface
    {
        return parent::setDescription($description);
    }

    /**
     * @param string $brief
     *
     * @return DtoInterface
     */
    public function setBrief(string $brief): DtoInterface
    {
        return parent::setBrief($brief);
    }

    /**
     * @param int|null $id
     *
     * @return DtoInterface
     */
    public function setId(?int $id): DtoInterface
    {
        return parent::setId($id);
    }
//endregion Getters/Setters
}