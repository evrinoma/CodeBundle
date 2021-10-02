<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Evrinoma\DtoBundle\Annotation\Dto;

class CodeApiDto extends AbstractDto implements CodeApiDtoInterface
{
//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\TypeApiDto", generator="genRequestTypApiDto")
     * @var TypeApiDto|null
     */
    private ?TypeApiDto $typeApiDto = null;
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\OwnerApiDto", generator="genRequestOwnerApiDto")
     * @var OwnerApiDto|null
     */
    private ?OwnerApiDto $ownerApiDto = null;
    private string       $id          = '';

    private string $description = '';

    private string $brief = '';

    private string $active = '';
//endregion Fields

//region SECTION: Protected
    /**
     * @param string $active
     *
     * @return CodeApiDto
     */
    protected function setActive(string $active): CodeApiDto
    {
        $this->active = $active;

        return $this;
    }
//endregion Protected

//region SECTION: Public
    public function hasId(): bool
    {
        return $this->id !== '';
    }

    public function hasActive(): bool
    {
        return $this->active !== '';
    }

    public function hasDescription(): bool
    {
        return $this->description !== '';
    }

    public function hasBrief(): bool
    {
        return $this->brief !== '';
    }

//endregion Public

//region SECTION: Dto
    /**
     * @param OwnerApiDto $ownerApiDto
     *
     * @return CodeApiDto
     */
    public function setOwnerApiDto(OwnerApiDto $ownerApiDto): CodeApiDto
    {
        $this->ownerApiDto = $ownerApiDto;

        return $this;
    }

    /**
     * @param TypeApiDto $typeApiDto
     *
     * @return CodeApiDto
     */
    public function setTypeApiDto(TypeApiDto $typeApiDto): CodeApiDto
    {
        $this->typeApiDto = $typeApiDto;

        return $this;
    }

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id          = $request->get(ModelInterface::ID);
            $brief       = $request->get(ModelInterface::BRIEF);
            $description = $request->get(ModelInterface::DESCRIPTION);
            $active      = $request->get(ModelInterface::ACTIVE);

            if ($active) {
                $this->setActive($active);
            }

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

    /**
     * @param string $description
     *
     * @return CodeApiDto
     */
    private function setDescription(string $description): CodeApiDto
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return CodeApiDto
     */
    private function setId(string $id): CodeApiDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $brief
     *
     * @return CodeApiDto
     */
    private function setBrief(string $brief): CodeApiDto
    {
        $this->brief = $brief;

        return $this;
    }

    public function hasOwnerApiDto(): bool
    {
        return $this->ownerApiDto !== null;
    }

    public function getOwnerApiDto(): OwnerApiDto
    {
        return $this->ownerApiDto;
    }

    public function hasTypeApiDto(): bool
    {
        return $this->typeApiDto !== null;
    }

    public function getTypeApiDto(): TypeApiDto
    {
        return $this->typeApiDto;
    }

    /**
     * @return \Generator
     */
    public function genRequestOwnerApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $owner = $request->get('owner');
            if ($owner) {
                $newRequest                    = $this->getCloneRequest();
                $owner[DtoInterface::DTO_CLASS] = OwnerApiDto::class;
                $newRequest->request->add($owner);

                yield $newRequest;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function genRequestTypApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get('type');
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = TypeApiDto::class;
                $newRequest->request->add($type);

                yield $newRequest;
            }
        }
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
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

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

    public function getId(): string
    {
        return $this->id;
    }
//endregion Getters/Setters
}