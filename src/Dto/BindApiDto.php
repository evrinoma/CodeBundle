<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class BindApiDto extends AbstractDto implements BindApiDtoInterface
{
    use IdTrait, ActiveTrait;

//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\BunchApiDto", generator="genRequestBunchApiDto")
     * @var BunchApiDtoInterface|null
     */
    private ?BunchApiDtoInterface $bunchApiDto = null;

    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\CodeApiDto", generator="genRequestCodeApiDto")
     * @var CodeApiDtoInterface|null
     */
    private ?CodeApiDtoInterface $codeApiDto = null;
//endregion Fields

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active = $request->get(BindApiDtoInterface::ACTIVE);
            $id     = $request->get(BindApiDtoInterface::ID);

            if ($active) {
                $this->setActive($active);
            }

            if ($id) {
                $this->setId($id);
            }

        }

        return $this;
    }

    /**
     * @return \Generator
     */
    public function genRequestBunchApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get(BunchApiDtoInterface::BUNCH);
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = BunchApiDto::class;
                $newRequest->request->add($type);

                yield $newRequest;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function genRequestCodeApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get(CodeApiDtoInterface::CODE);
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = CodeApiDto::class;
                $newRequest->request->add($type);

                yield $newRequest;
            }
        }
    }

    /**
     * @return bool
     */
    public function hasBunchApiDto(): bool
    {
        return $this->bunchApiDto !== null;
    }

    /**
     * @return bool
     */
    public function hasCodeApiDto(): bool
    {
        return $this->codeApiDto !== null;
    }

    /**
     * @param BunchApiDtoInterface $bunchApiDto
     *
     * @return DtoInterface
     */
    public function setBunchApiDto(BunchApiDtoInterface $bunchApiDto): DtoInterface
    {
        $this->bunchApiDto = $bunchApiDto;

        return $this;
    }

    /**
     * @return BunchApiDtoInterface
     */
    public function getBunchApiDto(): BunchApiDtoInterface
    {
        return $this->bunchApiDto;
    }

    /**
     * @return CodeApiDtoInterface
     */
    public function getCodeApiDto(): CodeApiDtoInterface
    {
        return $this->codeApiDto;
    }

    /**
     * @param CodeApiDtoInterface $codeApiDto
     *
     * @return DtoInterface
     */
    public function setCodeApiDto(CodeApiDtoInterface $codeApiDto): DtoInterface
    {
        $this->codeApiDto = $codeApiDto;

        return $this;
    }
//endregion SECTION: Dto
}