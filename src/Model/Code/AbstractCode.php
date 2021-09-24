<?php

namespace Evrinoma\CodeBundle\Model\Code;

use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractCode
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_code", columns={"brief", "description", "bunch_id"})})
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
     * @var BunchInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\Bunch\BunchInterface")
     * @ORM\JoinColumn(name="bunch_id", referencedColumnName="id")
     */
    protected BunchInterface $bunch;

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
     * @return BunchInterface
     */
    public function getBunch(): BunchInterface
    {
        return $this->bunch;
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
     * @param BunchInterface $bunch
     *
     * @return CodeInterface
     */
    public function setBunch(BunchInterface $bunch): CodeInterface
    {
        $this->bunch = $bunch;

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
