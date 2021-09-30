<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class OwnerApiDto extends AbstractDto implements OwnerApiDtoInterface
{
//region SECTION: Fields
    private string $id = '';

    private string $brief = '';

    private string $description = '';
//endregion Fields

//region SECTION: Public
    public function hasId(): bool
    {
        return $this->id !== '';
    }

    public function hasBrief(): bool
    {
        return $this->brief !== '';
    }

    public function hasDescription(): bool
    {
        return $this->description !== '';
    }
//endregion Public


//region SECTION: Private
    /**
     * @param string $id
     *
     * @return OwnerApiDto
     */
    private function setId(string $id): OwnerApiDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $brief
     *
     * @return OwnerApiDto
     */
    private function setBrief(string $brief): OwnerApiDto
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return OwnerApiDto
     */
    private function setDescription(string $description): OwnerApiDto
    {
        $this->description = $description;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id          = $request->get(ModelInterface::ID);
            $brief       = $request->get(ModelInterface::BRIEF);
            $description = $request->get(ModelInterface::DESCRIPTION);

            if ($brief) {
                $this->setBrief($brief);
            }

            if ($description) {
                $this->setDescription($description);
            }

            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBrief(): string
    {
        return $this->brief;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
//endregion Getters/Setters
}