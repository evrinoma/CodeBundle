<?php


namespace Evrinoma\CodeBundle\Validator;


use Evrinoma\CodeBundle\Entity\BaseOwner;
use Evrinoma\CodeBundle\Entity\BaseType;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;

final class TypeValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseType::class;
//endregion Fields

//region SECTION: Constructor
    /**
     * ContractorValidator constructor.
     *
     * @param string $entityClass
     */
    public function __construct(string $entityClass)
    {
        parent::__construct($entityClass);
    }
//endregion Constructor
}