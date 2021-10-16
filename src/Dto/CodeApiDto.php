<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\BriefTrait;
use Evrinoma\DtoCommon\ValueObject\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class CodeApiDto extends AbstractDto implements CodeApiDtoInterface
{
//region SECTION: Fields
    use IdTrait, ActiveTrait, DescriptionTrait, BriefTrait;

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
     * @param string $description
     */
    private function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param int|null $id
     */
    private function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $brief
     */
    private function setBrief(string $brief): void
    {
        $this->brief = $brief;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param OwnerApiDto $ownerApiDto
     */
    public function setOwnerApiDto(OwnerApiDto $ownerApiDto): void
    {
        $this->ownerApiDto = $ownerApiDto;
    }

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
                $newRequest                     = $this->getCloneRequest();
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
}