<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

class CodeApiDto extends AbstractDto implements CodeApiDtoInterface
{
//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\BunchApiDto", generator="genRequestBunchApiDto")
     * @var BunchApiDto|null
     */
    private ?BunchApiDto $bunchApiDto = null;
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
    protected function setOwnerApiDto(OwnerApiDto $ownerApiDto): CodeApiDto
    {
        $this->ownerApiDto = $ownerApiDto;

        return $this;
    }

    /**
     * @param BunchApiDto $bunchApiDto
     *
     * @return CodeApiDto
     */
    protected function setBunchApiDto(BunchApiDto $bunchApiDto): CodeApiDto
    {
        $this->bunchApiDto = $bunchApiDto;

        return $this;
    }

    public function toDto(Request $request): DtoInterface
    {
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

    public function hasBunchApiDto(): bool
    {
        return $this->bunchApiDto !== null;
    }

    public function getBunchApiDto(): BunchApiDto
    {
        return $this->bunchApiDto;
    }

    /**
     * @return \Generator
     */
    public function genRequestOwnerApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get('owner');
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = OwnerApiDto::class;
                $newRequest->request->add($type);

                yield $newRequest;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function genRequestBunchApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get('bunch');
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = BunchApiDto::class;
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