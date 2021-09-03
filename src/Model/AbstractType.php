<?php


namespace Evrinoma\CodeBundle\Model;


use Evrinoma\UtilsBundle\Entity\IdTrait;

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
//endregion Getters/Setters

}