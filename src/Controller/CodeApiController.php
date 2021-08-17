<?php

namespace Evrinoma\CodeBundle\Controller;

use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class CodeApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var ?Request
     */
    private ?Request $request;
//endregion Fields

//region SECTION: Constructor


    /**
     * ApiController constructor.
     *
     * @param SerializerInterface $serializer
     * @param RequestStack        $requestStack
     * @param FactoryDtoInterface $factoryDto
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto
    ) {
        parent::__construct($serializer);
        $this->request    = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
    }

//endregion Constructor
}