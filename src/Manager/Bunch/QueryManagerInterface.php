<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDto;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchProxyException;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;

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

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchProxyException
     */
    public function proxy(BunchApiDtoInterface $dto): BunchInterface;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchNotFoundException
     */
    public function get(BunchApiDtoInterface $dto): BunchInterface;
//endregion Getters/Setters
}