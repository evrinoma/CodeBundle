<?php


namespace Evrinoma\CodeBundle\Validator;


use Evrinoma\CodeBundle\Entity\Define\BaseType;
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
    public function __construct()
    {
        parent::__construct(self::$entityClass);
    }
//endregion Constructor
}