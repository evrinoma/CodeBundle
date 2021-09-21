<?php


namespace Evrinoma\CodeBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractType
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_brief", columns={"brief"})})
 */
abstract class AbstractType implements TypeInterface
{
    use IdTrait;

//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="brief", type="string", length=63, nullable=false)
     */
    protected string $brief;
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
     * @param string $brief
     *
     * @return AbstractType
     */
    public function setBrief(string $brief): self
    {
        $this->brief = $brief;

        return $this;
    }
//endregion Getters/Setters

}