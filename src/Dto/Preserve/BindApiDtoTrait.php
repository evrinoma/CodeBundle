<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait BindApiDtoTrait
{
//region SECTION: Dto
    /**
     * @param CodeApiDto $codeApiDto
     *
     * @return self|DtoInterface
     */
    public function setCodeApiDto(CodeApiDto $codeApiDto): DtoInterface
    {
        return parent::setCodeApiDto($codeApiDto);
    }

    /**
     * @param BunchApiDto $bunchApiDto
     *
     * @return self|DtoInterface
     */
    public function setBunchApiDto(BunchApiDto $bunchApiDto): DtoInterface
    {
        return parent::setBunchApiDto($bunchApiDto);
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