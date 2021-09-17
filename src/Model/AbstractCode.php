<?php

namespace Evrinoma\CodeBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

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
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\BunchInterface")
     * @ORM\JoinColumn(name="bunch_id", referencedColumnName="id")
     */
    protected BunchInterface $bunch;

    /**
     * @var OwnerInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\OwnerInterface")
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
//endregion Getters/Setters


}
