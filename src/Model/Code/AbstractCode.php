<?php

namespace Evrinoma\CodeBundle\Model\Code;

use Evrinoma\CodeBundle\Model\Define\OwnerInterface;
use Evrinoma\CodeBundle\Model\Define\TypeInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractCode
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_code", columns={"brief", "description", "owner_id"})})
 */
abstract class AbstractCode implements CodeInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait;

//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="brief", type="string", length=63, nullable=false)
     */
    protected string $brief;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    protected string $description;

    /**
     * @var TypeInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\Define\TypeInterface")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected TypeInterface $type;


    /**
     * @var OwnerInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\Define\OwnerInterface")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected OwnerInterface $owner;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getBrief(): string
    {
        return $this->brief;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface
    {
        return $this->type;
    }

    /**
     * @return OwnerInterface
     */
    public function getOwner(): OwnerInterface
    {
        return $this->owner;
    }

    /**
     * @param string $brief
     *
     * @return CodeInterface
     */
    public function setBrief(string $brief): CodeInterface
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return CodeInterface
     */
    public function setDescription(string $description): CodeInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param TypeInterface $type
     *
     * @return CodeInterface
     */
    public function setType(TypeInterface $type): CodeInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param OwnerInterface $owner
     *
     * @return CodeInterface
     */
    public function setOwner(OwnerInterface $owner): CodeInterface
    {
        $this->owner = $owner;

        return $this;
    }
//endregion Getters/Setters
}
