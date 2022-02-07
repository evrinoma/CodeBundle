<?php

namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait BunchApiDtoTrait
{
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