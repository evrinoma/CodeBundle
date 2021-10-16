<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\BriefTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

final class TypeApiDto extends AbstractDto implements TypeApiDtoInterface
{
    use IdTrait, BriefTrait;

//region SECTION: Private

    /**
     * @param string $id
     */
    private function setId(string $id): void
    {
        $this->id = $id;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id    = $request->get(ModelInterface::ID);
            $brief = $request->get(ModelInterface::BRIEF);

            if ($brief) {
                $this->setBrief($brief);
            }

            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @param string $brief
     */
    public function setBrief(string $brief): void
    {
        $this->brief = $brief;
    }
//endregion Getters/Setters
}