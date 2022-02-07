<?php

namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait BindApiDtoTrait
{
//region SECTION: Dto
    /**
     * @param CodeApiDtoInterface $codeApiDto
     *
     * @return self|DtoInterface
     */
    public function setCodeApiDto(CodeApiDtoInterface $codeApiDto): DtoInterface
    {
        return parent::setCodeApiDto($codeApiDto);
    }

    /**
     * @param BunchApiDtoInterface $bunchApiDto
     *
     * @return self|DtoInterface
     */
    public function setBunchApiDto(BunchApiDtoInterface $bunchApiDto): DtoInterface
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