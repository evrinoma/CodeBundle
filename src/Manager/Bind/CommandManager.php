<?php

namespace Evrinoma\CodeBundle\Manager\Bind;

use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bind\BindInvalidException;
use Evrinoma\CodeBundle\Exception\Bind\BindNotFoundException;
use Evrinoma\CodeBundle\Factory\BindFactoryInterface;
use Evrinoma\CodeBundle\Manager\Bunch\QueryManagerInterface as BunchQueryManagerInterface;
use Evrinoma\CodeBundle\Manager\Code\QueryManagerInterface as CodeQueryManagerInterface;
use Evrinoma\CodeBundle\Mediator\Bind\CommandMediatorInterface;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;
use Evrinoma\CodeBundle\Repository\Bind\BindCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private BindFactoryInterface           $factory;
    private BindCommandRepositoryInterface $repository;
    private ValidatorInterface             $validator;
    private CommandMediatorInterface       $mediator;
    private BunchQueryManagerInterface     $bunchQueryManager;
    private CodeQueryManagerInterface      $codeQueryManager;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ValidatorInterface $validator, BindCommandRepositoryInterface $repository, BindFactoryInterface $factory, CommandMediatorInterface $mediator, BunchQueryManagerInterface $bunchQueryManager, CodeQueryManagerInterface $codeQueryManager)
    {
        $this->validator         = $validator;
        $this->repository        = $repository;
        $this->factory           = $factory;
        $this->mediator          = $mediator;
        $this->bunchQueryManager = $bunchQueryManager;
        $this->codeQueryManager  = $codeQueryManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     * @throws BindCannotBeSavedException
     * @throws BindInvalidException
     * @throws BindNotFoundException
     */
    public function put(BindApiDtoInterface $dto): BindInterface
    {
        try {
            $bind = $this->repository->find($dto->getId());
        } catch (BindNotFoundException $e) {
            throw $e;
        }

        try {
            /** @var $bind BindInterface */
            $bind->setBunch($this->bunchQueryManager->proxy($dto->getBunchApiDto()));
        } catch (\Exception $e) {
            throw new BindCannotBeSavedException($e->getMessage());
        }

        try {
            /** @var $bind BindInterface */
            $bind->setCode($this->codeQueryManager->proxy($dto->getCodeApiDto()));
        } catch (\Exception $e) {
            throw new BindCannotBeSavedException($e->getMessage());
        }

        $bind
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        $this->mediator->onUpdate($dto, $bind);

        $errors = $this->validator->validate($bind);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new BindInvalidException($errorsString);
        }

        $this->repository->save($bind);

        return $bind;
    }

    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     * @throws BindCannotBeCreatedException
     * @throws BindCannotBeSavedException
     * @throws BindInvalidException
     */
    public function post(BindApiDtoInterface $dto): BindInterface
    {
        $bind = $this->factory->create($dto);

        try {
            /** @var $bind BindInterface */
            $bind->setBunch($this->bunchQueryManager->proxy($dto->getBunchApiDto()));
        } catch (\Exception $e) {
            throw new BindCannotBeSavedException($e->getMessage());
        }

        try {
            /** @var $bind BindInterface */
            $bind->setCode($this->codeQueryManager->proxy($dto->getCodeApiDto()));
        } catch (\Exception $e) {
            throw new BindCannotBeSavedException($e->getMessage());
        }

        $this->mediator->onCreate($dto, $bind);

        $errors = $this->validator->validate($bind);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new BindInvalidException($errorsString);
        }

        $this->repository->save($bind);

        return $bind;
    }

    /**
     * @param BindApiDtoInterface $dto
     *
     * @throws BindCannotBeRemovedException
     * @throws BindNotFoundException
     */
    public function delete(BindApiDtoInterface $dto): void
    {
        try {
            $bind = $this->repository->find($dto->getId());
        } catch (BindNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $bind);
        try {
            $this->repository->remove($bind);
        } catch (BindCannotBeRemovedException $e) {
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