<?php

namespace Evrinoma\CodeBundle\Model\Define;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractOwner
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_brief", columns={"brief"})})
 */
abstract class AbstractOwner implements OwnerInterface
{
    use IdTrait;

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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    protected string $description;

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
     * @param string $brief
     *
     * @return AbstractOwner
     */
    public function setBrief(string $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return AbstractOwner
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
//endregion Getters/Setters
}