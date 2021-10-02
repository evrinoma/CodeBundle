<?php


namespace Evrinoma\CodeBundle\Model\Bind;

use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractCode
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_code", columns={"bunch_id", "code_id"})})
 */
abstract class AbstractBind implements BindInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait;

//region SECTION: Fields
    /**
     * @var BunchInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\Bunch\BunchInterface")
     * @ORM\JoinColumn(name="bunch_id", referencedColumnName="id")
     */
    protected BunchInterface $bunch;

    /**
     * @var CodeInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\CodeBundle\Model\Code\CodeInterface")
     * @ORM\JoinColumn(name="code_id", referencedColumnName="id")
     */
    protected CodeInterface $code;

    /**
     * @return BunchInterface
     */
    public function getBunch(): BunchInterface
    {
        return $this->bunch;
    }

    /**
     * @param BunchInterface $bunch
     *
     * @return BindInterface
     */
    public function setBunch(BunchInterface $bunch): BindInterface
    {
        $this->bunch = $bunch;

        return $this;
    }

    /**
     * @return CodeInterface
     */
    public function getCode(): CodeInterface
    {
        return $this->code;
    }

    /**
     * @param CodeInterface $code
     *
     * @return BindInterface
     */
    public function setCode(CodeInterface $code): BindInterface
    {
        $this->code = $code;

        return $this;
    }
//endregion Fields
}