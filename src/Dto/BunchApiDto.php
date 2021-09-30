<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Evrinoma\DtoBundle\Annotation\Dto;

class BunchApiDto extends AbstractDto implements BunchApiDtoInterface
{
//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\TypeApiDto", generator="genRequestTypeApiDto")
     * @var TypeApiDto|null
     */
    private ?TypeApiDto $typeApiDto = null;

    private string $id = '';

    private string $description = '';

    private string $active = '';
//endregion Fields

//region SECTION: Protected
    /**
     * @param string $active
     *
     * @return BunchApiDto
     */
    protected function setActive(string $active): BunchApiDto
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
//endregion Public

//region SECTION: Private
    /**
     * @param string $id
     *
     * @return BunchApiDto
     */
    private function setId(string $id): BunchApiDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return BunchApiDto
     */
    private function setDescription(string $description): BunchApiDto
    {
        $this->description = $description;

        return $this;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param TypeApiDto $typeApiDto
     *
     * @return BunchApiDto
     */
    public function setTypeApiDto(TypeApiDto $typeApiDto): BunchApiDto
    {
        $this->typeApiDto = $typeApiDto;

        return $this;
    }

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id          = $request->get(ModelInterface::ID);
            $description = $request->get(ModelInterface::DESCRIPTION);

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
     * @return TypeApiDto
     */
    public function getTypeApiDto(): TypeApiDto
    {
        return $this->typeApiDto;
    }

    /**
     * @return \Generator
     */
    public function genRequestTypeApiDto(?Request $request): ?\Generator
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

    /**
     * @return bool
     */
    public function hasTypeApiDto(): bool
    {
        return $this->typeApiDto !== null;
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
//endregion Getters/Setters
}