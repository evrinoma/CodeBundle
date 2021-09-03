<?php


namespace Evrinoma\CodeBundle\Model;


use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractOwner
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_coder", columns={"brief"})})
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
}