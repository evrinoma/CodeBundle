<?php


namespace Evrinoma\CodeBundle\Manager\Code;


use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Code\CodeNotFoundException;
use Evrinoma\CodeBundle\Exception\Code\CodeProxyException;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return array
     * @throws CodeNotFoundException
     */
    public function criteria(CodeApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     * @throws CodeNotFoundException
     */
    public function get(CodeApiDtoInterface $dto): CodeInterface;

    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     * @throws CodeProxyException
     */
    public function proxy(CodeApiDtoInterface $dto): CodeInterface;
//endregion Getters/Setters
}