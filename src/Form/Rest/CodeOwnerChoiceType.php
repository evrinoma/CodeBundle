<?php

namespace Evrinoma\CodeBundle\Form\Rest;

use Evrinoma\CodeBundle\Dto\OwnerApiDto;
use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Manager\Owner\QueryManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodeOwnerChoiceType extends AbstractType
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
                    $criteria = $this->queryManager->criteria(new OwnerApiDto());
                    switch ($options->offsetGet('data')) {
                        case  OwnerApiDtoInterface::BRIEF:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getBrief();
                            }
                            break;
                        case  OwnerApiDtoInterface::DESCRIPTION:
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
                    throw new OwnerNotFoundException();
                }
            } catch (OwnerNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'owner');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'ownerList');
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