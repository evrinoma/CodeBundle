<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\BriefTrait;
use Evrinoma\DtoCommon\ValueObject\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

final class OwnerApiDto extends AbstractDto implements OwnerApiDtoInterface
{
    use IdTrait, DescriptionTrait, BriefTrait;

//region SECTION: Private

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

    /**
     * @param string $description
     */
    private function setDescription(string $description): void
    {
        $this->description = $description;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id          = $request->get(ModelInterface::ID);
            $brief       = $request->get(ModelInterface::BRIEF);
            $description = $request->get(ModelInterface::DESCRIPTION);

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
//endregion SECTION: Dto
}