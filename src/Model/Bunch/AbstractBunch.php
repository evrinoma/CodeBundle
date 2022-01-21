<?php


namespace Evrinoma\CodeBundle\Model\Bunch;

use Evrinoma\CodeBundle\Model\Define\TypeInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\DescriptionTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractCode
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_code", columns={"type_id", "description"})})
 */
abstract class AbstractBunch implements BunchInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait, DescriptionTrait;

//region SECTION: Fields
    /**
     * @var TypeInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\Define\TypeInterface")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected TypeInterface $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    protected string $description;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface
    {
        return $this->type;
    }

    /**
     * @param TypeInterface $type
     *
     * @return self
     */
    public function setType(TypeInterface $type): self
    {
        $this->type = $type;

        return $this;
    }
//endregion Getters/Setters
}