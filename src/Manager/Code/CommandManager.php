<?php

namespace Evrinoma\CodeBundle\Manager\Code;

use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Entity\Code\BaseCode;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Code\CodeInvalidException;
use Evrinoma\CodeBundle\Exception\Code\CodeNotFoundException;
use Evrinoma\CodeBundle\Factory\CodeFactoryInterface;
use Evrinoma\CodeBundle\Manager\Type\QueryManagerInterface as TypeQueryManagerInterface;
use Evrinoma\CodeBundle\Manager\Owner\QueryManagerInterface as OwnerQueryManagerInterface;
use Evrinoma\CodeBundle\Mediator\Code\CommandMediatorInterface;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;
use Evrinoma\CodeBundle\Repository\Code\CodeCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;


final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private ValidatorInterface             $validator;
    private CodeCommandRepositoryInterface $repository;
    private CodeFactoryInterface           $factory;
    private CommandMediatorInterface       $mediator;
    private OwnerQueryManagerInterface     $ownerQueryManager;
    private TypeQueryManagerInterface      $typeQueryManager;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ValidatorInterface $validator, CodeCommandRepositoryInterface $repository, CodeFactoryInterface $factory, CommandMediatorInterface $mediator, OwnerQueryManagerInterface $ownerQueryManager, TypeQueryManagerInterface $typeQueryManager)
    {
        $this->validator         = $validator;
        $this->repository        = $repository;
        $this->factory           = $factory;
        $this->mediator          = $mediator;
        $this->ownerQueryManager = $ownerQueryManager;
        $this->typeQueryManager  = $typeQueryManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     * @throws CodeCannotBeSavedException
     * @throws CodeInvalidException
     */
    public function put(CodeApiDtoInterface $dto): CodeInterface
    {
        /** @var BaseCode $code */
        try {
            $code = $this->repository->find($dto->getId());
        } catch (CodeNotFoundException $e) {
            throw $e;
        }

        try {
            $code->setOwner($this->ownerQueryManager->proxy($dto->getOwnerApiDto()));
        } catch (\Exception $e) {
            throw new CodeCannotBeCreatedException($e->getMessage());
        }

        try {
            $code->setType($this->typeQueryManager->proxy($dto->getTypeApiDto()));
        } catch (\Exception $e) {
            throw new CodeCannotBeCreatedException($e->getMessage());
        }

        $code
            ->setBrief($dto->getBrief())
            ->setDescription($dto->getDescription())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        $this->mediator->onUpdate($dto, $code);

        $errors = $this->validator->validate($code);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new CodeInvalidException($errorsString);
        }

        $this->repository->save($code);

        return $code;
    }

    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     * @throws CodeCannotBeSavedException
     * @throws CodeInvalidException
     * @throws CodeCannotBeCreatedException
     */
    public function post(CodeApiDtoInterface $dto): CodeInterface
    {
        $code = $this->factory->create($dto);

        try {
            $code->setOwner($this->ownerQueryManager->proxy($dto->getOwnerApiDto()));
        } catch (\Exception $e) {
            throw new CodeCannotBeCreatedException($e->getMessage());
        }

        try {
            $code->setType($this->typeQueryManager->proxy($dto->getTypeApiDto()));
        } catch (\Exception $e) {
            throw new CodeCannotBeCreatedException($e->getMessage());
        }

        $this->mediator->onCreate($dto, $code);

        $errors = $this->validator->validate($code);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new CodeInvalidException($errorsString);
        }

        $this->repository->save($code);

        return $code;
    }

    /**
     * @param CodeApiDtoInterface $dto
     *
     * @throws CodeCannotBeRemovedException
     * @throws CodeNotFoundException
     */
    public function delete(CodeApiDtoInterface $dto): void
    {
        try {
            $code = $this->repository->find($dto->getId());
        } catch (CodeNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $code);
        try {
            $this->repository->remove($code);
        } catch (CodeCannotBeRemovedException $e) {
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