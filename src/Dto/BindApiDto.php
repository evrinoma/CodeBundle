<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class BindApiDto extends AbstractDto implements BindApiDtoInterface
{
    use IdTrait, ActiveTrait;

//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\BunchApiDto", generator="genRequestBunchApiDto")
     * @var BunchApiDto|null
     */
    private ?BunchApiDto $bunchApiDto = null;

    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\CodeApiDto", generator="genRequestCodeApiDto")
     * @var CodeApiDto|null
     */
    private ?CodeApiDto $codeApiDto = null;
//endregion Fields

//region SECTION: Private
    /**
     * @param string $active
     */
    private function setActive(string $active): void
    {
        $this->active = $active;
    }

    /**
     * @param int|null $id
     */
    private function setId(?int $id): void
    {
        $this->id = $id;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active = $request->get(ModelInterface::ACTIVE);
            $id     = $request->get(ModelInterface::ID);

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
            $type = $request->get('bunch');
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
            $type = $request->get('code');
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
     * @param BunchApiDto $bunchApiDto
     */
    public function setBunchApiDto(BunchApiDto $bunchApiDto): void
    {
        $this->bunchApiDto = $bunchApiDto;
    }

    /**
     * @return BunchApiDto
     */
    public function getBunchApiDto(): BunchApiDto
    {
        return $this->bunchApiDto;
    }

    /**
     * @return CodeApiDto
     */
    public function getCodeApiDto(): CodeApiDto
    {
        return $this->codeApiDto;
    }

    /**
     * @param CodeApiDto $codeApiDto
     */
    public function setCodeApiDto(CodeApiDto $codeApiDto): void
    {
        $this->codeApiDto = $codeApiDto;
    }
//endregion SECTION: Dto
}