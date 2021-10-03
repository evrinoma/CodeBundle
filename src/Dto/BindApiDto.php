<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Evrinoma\DtoBundle\Annotation\Dto;

class BindApiDto extends AbstractDto implements BindApiDtoInterface
{
//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\BunchApiDto", generator="genRequestBunchApiDto")
     * @var BunchApiDto|null
     */
    private ?BunchApiDto $bunchApiDto = null;

    private string $active = '';
    /**
     * @Dto(class="Evrinoma\CodeBundle\Dto\CodeApiDto", generator="genRequestCodeApiDto")
     * @var CodeApiDto|null
     */
    private ?CodeApiDto $codeApiDto = null;

    private string $id = '';
//endregion Fields

//region SECTION: Protected
    /**
     * @param string $active
     *
     * @return BindApiDto
     */
    protected function setActive(string $active): BindApiDto
    {
        $this->active = $active;

        return $this;
    }
//endregion Protected

//region SECTION: Public
    public function hasActive(): bool
    {
        return $this->active !== '';
    }

    public function hasId(): bool
    {
        return $this->id !== '';
    }

    /**
     * @param string $id
     *
     * @return BindApiDto
     */
    private function setId(string $id): BindApiDto
    {
        $this->id = $id;

        return $this;
    }
//endregion Public

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active = $request->get(ModelInterface::ACTIVE);
            $id          = $request->get(ModelInterface::ID);

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
     *
     * @return BindApiDto
     */
    public function setBunchApiDto(BunchApiDto $bunchApiDto): BindApiDto
    {
        $this->bunchApiDto = $bunchApiDto;

        return $this;
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
     *
     * @return BindApiDto
     */
    public function setCodeApiDto(CodeApiDto $codeApiDto): BindApiDto
    {
        $this->codeApiDto = $codeApiDto;

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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