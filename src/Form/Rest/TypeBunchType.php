<?php

use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeBunchType extends AbstractType
{


//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            return ['1', '2', '3', '4'];
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'typeBunch');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'typeBunchList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return RestChoiceType::class;
    }
//endregion Getters/Setters
}