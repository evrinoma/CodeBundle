<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class TypeApiDto extends AbstractDto implements TypeApiDtoInterface
{
//region SECTION: Fields
    private string $id = '';

    private string $brief = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->id !== '';
    }

    /**
     * @return bool
     */
    public function hasBrief(): bool
    {
        return $this->brief !== '';
    }
//endregion Public

//region SECTION: Private
    /**
     * @param string $id
     *
     * @return TypeApiDto
     */
    private function setId(string $id): TypeApiDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $brief
     *
     * @return TypeApiDto
     */
    private function setBrief(string $brief): TypeApiDto
    {
        $this->brief = $brief;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id    = $request->get(ModelInterface::ID);
            $brief = $request->get(ModelInterface::BRIEF);

            if ($brief) {
                $this->setBrief($brief);
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
//endregion Getters/Setters
}