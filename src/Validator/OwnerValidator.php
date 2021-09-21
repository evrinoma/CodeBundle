<?php


namespace Evrinoma\CodeBundle\Validator;


use Evrinoma\CodeBundle\Entity\BaseOwner;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;

final class OwnerValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseOwner::class;
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