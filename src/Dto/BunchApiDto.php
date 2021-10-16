<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class BunchApiDto extends AbstractDto implements BunchApiDtoInterface
{
//region SECTION: Fields
    use IdTrait, ActiveTrait, DescriptionTrait;

    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\TypeApiDto", generator="genRequestTypeApiDto")
     * @var TypeApiDto|null
     */
    private ?TypeApiDto $typeApiDto = null;
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

    /**
     * @param string $description
     */
    private function setDescription(string $description): void
    {
        $this->description = $description;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param TypeApiDto $typeApiDto
     */
    public function setTypeApiDto(TypeApiDto $typeApiDto): void
    {
        $this->typeApiDto = $typeApiDto;
    }

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id          = $request->get(ModelInterface::ID);
            $description = $request->get(ModelInterface::DESCRIPTION);
            $active      = $request->get(ModelInterface::ACTIVE);

            if ($active) {
                $this->setActive($active);
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
}