<?php

namespace Evrinoma\CodeBundle\Manager\Code;

use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Code\CodeInvalidException;
use Evrinoma\CodeBundle\Exception\Code\CodeNotFoundException;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;

interface CommandManagerInterface
{
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     * @throws CodeCannotBeSavedException
     * @throws CodeInvalidException
     * @throws CodeNotFoundException
     */
    public function put(CodeApiDtoInterface $dto): CodeInterface;

    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     * @throws CodeCannotBeSavedException
     * @throws CodeInvalidException
     * @throws CodeCannotBeCreatedException
     */
    public function post(CodeApiDtoInterface $dto): CodeInterface;

    /**
     * @param CodeApiDtoInterface $dto
     *
     * @throws CodeCannotBeRemovedException
     * @throws CodeNotFoundException
     */
    public function delete(CodeApiDtoInterface $dto): void;
}