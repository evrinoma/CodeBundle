<?php

namespace Evrinoma\CodeBundle\Form\Rest;

use Evrinoma\CodeBundle\Dto\BunchApiDto;
use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Manager\Bunch\QueryManagerInterface;
use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BunchChoiceType extends AbstractType
{
//region SECTION: Fields
    private QueryManagerInterface $queryManager;
//endregion Fields

//region SECTION: Constructor
    public function __construct(QueryManagerInterface $queryManager)
    {
        $this->queryManager = $queryManager;
    }
//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $value = [];
            try {
                if ($options->offsetExists('data')) {
                    $criteria = $this->queryManager->criteria(new BunchApiDto());
                    switch ($options->offsetGet('data')) {
                        case  ModelInterface::DESCRIPTION:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getDescription();
                            }
                            break;
                        default:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getId();
                            }
                    }
                } else {
                    throw new BunchNotFoundException();
                }
            } catch (BunchNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'bunch');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'buncheList');
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