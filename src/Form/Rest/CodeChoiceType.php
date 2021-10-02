<?php

namespace Evrinoma\CodeBundle\Form\Rest;

use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Evrinoma\CodeBundle\Exception\Code\CodeNotFoundException;
use Evrinoma\CodeBundle\Manager\Code\QueryManagerInterface;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;
use Evrinoma\CodeBundle\Model\ModelInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodeChoiceType extends AbstractType
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
                    /** @var CodeInterface[] $criteria */
                    $criteria = $this->queryManager->criteria(new CodeApiDto());
                    switch ($options->offsetGet('data')) {
                        case  ModelInterface::DESCRIPTION:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getDescription();
                            }
                            break;
                        case  ModelInterface::BRIEF:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getBrief();
                            }
                            break;
                        default:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getId();
                            }
                    }
                } else {
                    throw new CodeNotFoundException();
                }
            } catch (CodeNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'code');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'codeList');
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