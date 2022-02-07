<?php


namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

trait CodeApiDtoTrait
{
//region SECTION: Dto
    /**
     * @param OwnerApiDtoInterface $ownerApiDto
     *
     * @return DtoInterface
     */
    public function setOwnerApiDto(OwnerApiDtoInterface $ownerApiDto): DtoInterface
    {
        return parent::setOwnerApiDto($ownerApiDto);
    }

    /**
     * @param TypeApiDtoInterface $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(TypeApiDtoInterface $typeApiDto): DtoInterface
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