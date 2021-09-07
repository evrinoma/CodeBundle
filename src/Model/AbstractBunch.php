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
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_code", columns={"type_id", "description"})})
 */
abstract class AbstractBunch implements BunchInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait;

    /**
     * @var TypeInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\TypeInterface")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected TypeInterface $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    protected string $description;
}