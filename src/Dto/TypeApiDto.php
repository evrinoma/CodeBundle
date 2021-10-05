<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\BriefTrait;
use Evrinoma\DtoCommon\ValueObject\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\IdInterface;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

final class TypeApiDto extends AbstractDto implements TypeApiDtoInterface
{
    use IdTrait, BriefTrait;

//region SECTION: Private
    /**
     * @param string $id
     *
     * @return TypeApiDto
     */
    private function setId(string $id): TypeApiDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $brief
     *
     * @return TypeApiDto
     */
    public function setBrief(string $brief): TypeApiDto
    {
        $this->brief = $brief;

        return $this;
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
}