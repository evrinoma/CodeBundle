<?php


namespace Evrinoma\CodeBundle\Validator;


use Evrinoma\CodeBundle\Entity\Code\BaseCode;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @param ValidatorInterface $validator
     * @param string             $entityClass
     */
    public function __construct(ValidatorInterface $validator, string $entityClass)
    {
        parent::__construct($validator, $entityClass);
    }
//endregion Constructor
}