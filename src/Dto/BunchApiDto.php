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
     * @var TypeApiDto
     */
    private $typeApiDto;

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
        // TODO: Implement hasId() method.
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
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    public function getId(): string
    {
        // TODO: Implement getId() method.
    }

    public function getDescription(): string
    {
        // TODO: Implement getDescription() method.
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