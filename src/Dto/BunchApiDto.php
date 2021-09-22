<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

class BunchApiDto extends AbstractDto implements BunchApiDtoInterface
{
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\TypeApiDto", generator="genRequestTypeApiDto")
     * @var TypeApiDto
     */
    private $typeApiDto;

    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }

    public function hasId(): bool
    {
        // TODO: Implement hasId() method.
    }

    public function getId(): string
    {
        // TODO: Implement getId() method.
    }

    /**
     * @return TypeApiDto
     */
    public function getTypeApiDto(): TypeApiDto
    {
        return $this->typeApiDto;
    }

    /**
     * @param TypeApiDto $typeApiDto
     */
    private function setTypeApiDto(TypeApiDto $typeApiDto): void
    {
        $this->typeApiDto = $typeApiDto;
    }


    public function getDescription(): string
    {
        // TODO: Implement getDescription() method.
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
}