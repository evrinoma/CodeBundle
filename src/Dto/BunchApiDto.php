<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

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

//region SECTION: Dto
    /**
     * @param TypeApiDto $typeApiDto
     *
     * @return BunchApiDto
     */
    protected function setTypeApiDto(TypeApiDto $typeApiDto): BunchApiDto
    {
        $this->typeApiDto = $typeApiDto;

        return $this;
    }

    public function toDto(Request $request): DtoInterface
    {
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
            $domain = $request->get('type');
            if ($domain) {
                $newRequest                      = $this->getCloneRequest();
                $domain[DtoInterface::DTO_CLASS] = TypeApiDto::class;
                $newRequest->request->add($domain);

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