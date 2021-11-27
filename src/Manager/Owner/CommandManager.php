<?php

namespace Evrinoma\CodeBundle\Manager\Owner;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerInvalidException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Factory\OwnerFactoryInterface;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;
use Evrinoma\CodeBundle\Repository\Owner\OwnerCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private OwnerCommandRepositoryInterface $repository;
    private OwnerFactoryInterface    $factory;
    private ValidatorInterface       $validator;
//endregion Fields

//region SECTION: Constructor
    /**
     * CommandManager constructor.
     *
     * @param ValidatorInterface       $validator
     * @param OwnerCommandRepositoryInterface $repository
     * @param OwnerFactoryInterface    $factory
     */
    public function __construct(ValidatorInterface $validator, OwnerCommandRepositoryInterface $repository, OwnerFactoryInterface $factory)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
        $this->factory    = $factory;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return OwnerInterface
     * @throws OwnerCannotBeCreatedException
     * @throws OwnerInvalidException
     */
    public function post(OwnerApiDtoInterface $dto): OwnerInterface
    {
        $owner = $this->factory->create($dto);

        $errors = $this->validator->validate($owner);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new OwnerInvalidException($errorsString);
        }

        $this->repository->save($owner);

        return $owner;
    }

    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return OwnerInterface
     * @throws OwnerInvalidException
     * @throws OwnerNotFoundException
     * @throws OwnerCannotBeSavedException
     */
    public function put(OwnerApiDtoInterface $dto): OwnerInterface
    {
        try {
            $owner = $this->repository->find($dto->getId());
        } catch (OwnerNotFoundException $e) {
            throw $e;
        }

        $owner
            ->setBrief($dto->getBrief())
            ->setDescription($dto->getDescription());

        $errors = $this->validator->validate($owner);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new OwnerInvalidException($errorsString);
        }

        $this->repository->save($owner);

        return $owner;
    }

    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @throws OwnerCannotBeRemovedException
     * @throws OwnerNotFoundException
     */
    public function delete(OwnerApiDtoInterface $dto): void
    {
        try {
            $contractor = $this->repository->find($dto->getId());
        } catch (OwnerNotFoundException $e) {
            throw $e;
        }
        try {
            $this->repository->remove($contractor);
        } catch (OwnerCannotBeRemovedException $e) {
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