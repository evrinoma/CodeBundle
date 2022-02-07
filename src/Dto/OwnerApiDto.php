<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\BriefTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class OwnerApiDto extends AbstractDto implements OwnerApiDtoInterface
{
    use IdTrait, DescriptionTrait, BriefTrait;

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id          = $request->get(OwnerApiDtoInterface::ID);
            $brief       = $request->get(OwnerApiDtoInterface::BRIEF);
            $description = $request->get(OwnerApiDtoInterface::DESCRIPTION);

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