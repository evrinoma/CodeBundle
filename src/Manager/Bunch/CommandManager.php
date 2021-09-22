<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\CodeBindle\Mediator\Bunch\CommandMediatorInterface;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchInvalidException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Factory\BunchFactoryInterface;
use Evrinoma\CodeBundle\Model\BunchInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private BunchFactoryInterface      $factory;
    private CommandRepositoryInterface $repository;
    private ValidatorInterface         $validator;
    private CommandMediatorInterface $mediator;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ValidatorInterface $validator, CommandRepositoryInterface $repository, BunchFactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
        $this->factory    = $factory;
        $this->mediator   = $mediator;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchCannotBeSavedException
     * @throws BunchInvalidException
     */
    public function put(BunchApiDtoInterface $dto): BunchInterface
    {
        // TODO: Implement put() method.
    }

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchNotFoundException
     * @throws BunchCannotBeSavedException
     * @throws BunchInvalidException
     */
    public function post(BunchApiDtoInterface $dto): BunchInterface
    {
        $bunch = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $bunch);

        $errors = $this->validator->validate($bunch);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new BunchInvalidException($errorsString);
        }

        $this->repository->save($bunch);

        return $bunch;
    }

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @throws BunchCannotBeRemovedException
     * @throws BunchNotFoundException
     */
    public function delete(BunchApiDtoInterface $dto): void
    {
        try {
            $bunch = $this->repository->find($dto->getId());
        } catch (BunchNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $bunch);
        try {
            $this->repository->remove($bunch);
        } catch (BunchCannotBeRemovedException $e) {
            throw $e;
        }
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}