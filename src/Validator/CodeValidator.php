<?php


namespace Evrinoma\CodeBundle\Validator;


use Evrinoma\CodeBundle\Entity\Code\BaseCode;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;

final class CodeValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseCode::class;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param string $entityClass
     */
    public function __construct(string $entityClass)
    {
        parent::__construct($entityClass);
    }
//endregion Constructor
}