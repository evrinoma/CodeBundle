<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\CodeBundle\Mediator\Bunch\CommandMediatorInterface;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchInvalidException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Factory\BunchFactoryInterface;
use Evrinoma\CodeBundle\Manager\Type\QueryManagerInterface;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Repository\Bunch\BunchCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private BunchFactoryInterface           $factory;
    private BunchCommandRepositoryInterface $repository;
    private ValidatorInterface              $validator;
    private CommandMediatorInterface        $mediator;
    private QueryManagerInterface $typeQueryManager;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ValidatorInterface $validator, BunchCommandRepositoryInterface $repository, BunchFactoryInterface $factory, CommandMediatorInterface $mediator, QueryManagerInterface $typeQueryManager)
    {
        $this->validator        = $validator;
        $this->repository       = $repository;
        $this->factory          = $factory;
        $this->mediator         = $mediator;
        $this->typeQueryManager = $typeQueryManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchCannotBeSavedException
     * @throws BunchInvalidException
     * @throws BunchNotFoundException
     */
    public function put(BunchApiDtoInterface $dto): BunchInterface
    {
        try {
            $bunch = $this->repository->find($dto->getId());
        } catch (BunchNotFoundException $e) {
            throw $e;
        }

        try {
            $bunch->setType($this->typeQueryManager->proxy($dto->getTypeApiDto()));
        } catch (\Exception $e) {
            throw new BunchCannotBeSavedException($e->getMessage());
        }

        $bunch
            ->setDescription($dto->getDescription())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        $this->mediator->onUpdate($dto, $bunch);

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
     * @return BunchInterface
     * @throws BunchCannotBeCreatedException
     * @throws BunchCannotBeSavedException
     * @throws BunchInvalidException
     */
    public function post(BunchApiDtoInterface $dto): BunchInterface
    {
        $bunch = $this->factory->create($dto);

        try {
            $bunch->setType($this->typeQueryManager->proxy($dto->getTypeApiDto()));
        } catch (\Exception $e) {
            throw new BunchCannotBeCreatedException($e->getMessage());
        }

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