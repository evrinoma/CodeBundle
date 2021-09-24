<?php


namespace Evrinoma\CodeBundle\Validator;


use Evrinoma\CodeBundle\Entity\Define\BaseOwner;
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
    public function __construct()
    {
        parent::__construct(self::$entityClass);
    }
//endregion Constructor
}