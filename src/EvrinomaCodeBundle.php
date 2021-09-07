<?php


namespace Evrinoma\CodeBundle;

use Evrinoma\CodeBundle\DependencyInjection\EvrinomaCodeExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * Class CodeBundle
 *
 * @package Evrinoma\CodeBundle
 */
class EvrinomaCodeBundle extends Bundle
{
//region SECTION: Fields
    public const CODE_BUNDLE = 'code';
//endregion Fields

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaCodeExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}