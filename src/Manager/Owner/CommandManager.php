<?php

namespace Evrinoma\CodeBundle\Manager\Owner;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerInvalidException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Factory\OwnerFactoryInterface;
use Evrinoma\CodeBundle\Model\OwnerInterface;
use Evrinoma\CodeBundle\Repository\Owner\OwnerRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

    private OwnerRepositoryInterface $repository;
    private OwnerFactoryInterface    $factory;
    private OwnerValidatorInterface  $validator;

    /**
     * CommandManager constructor.
     *
     * @param OwnerValidatorInterface  $validator
     * @param OwnerRepositoryInterface $repository
     * @param OwnerFactoryInterface    $factory
     */
    public function __construct(OwnerValidatorInterface $validator, OwnerRepositoryInterface $repository, OwnerFactoryInterface $factory)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
        $this->factory    = $factory;
    }

//region SECTION: Public
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

    public function put(OwnerApiDtoInterface $dto): OwnerInterface
    {
        try {
            $owner = $this->repository->find($dto->getId());
        } catch (OwnerNotFoundException $e) {
            throw $e;
        }

        $owner
            ->setBrief($dto->getBrief())
            ->setDescription($dto->getDescription())
        ;

        $errors = $this->validator->validate($owner);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new OwnerInvalidException($errorsString);
        }

        $this->repository->save($owner);

        return $owner;
    }

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
    public function getRestStatus(): int
    {
        return $this->status;
    }
}