<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDto;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return array
     * @throws BunchNotFoundException
     */
    public function criteria(BunchApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchApiDto
     * @throws BunchNotFoundException
     */
    public function get(BunchApiDtoInterface $dto): BunchApiDto;
//endregion Getters/Setters
}