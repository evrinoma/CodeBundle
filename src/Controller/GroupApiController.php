<?php

namespace Evrinoma\CodeBundle\Controller;

use Evrinoma\CodeBundle\Manager\Group\CommandManagerInterface;
use Evrinoma\CodeBundle\Manager\Group\QueryManagerInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class GroupApiController extends AbstractApiController implements ApiControllerInterface
{
//region SECTION: Fields
    private string                  $dtoClass;
    private QueryManagerInterface   $queryManager;
    private CommandManagerInterface $commandManager;
    private FactoryDtoInterface     $factoryDto;
    private ?Request                $request;
//endregion Fields

//region SECTION: Constructor
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        CommandManagerInterface $commandManager,
        QueryManagerInterface $queryManager,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->factoryDto     = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager   = $queryManager;
        $this->dtoClass       = $dtoClass;
    }
//endregion Constructor


    public function getAction(): JsonResponse
    {

    }

    public function putAction(): JsonResponse
    {

    }

    public function postAction(): JsonResponse
    {

    }

    public function deleteAction(): JsonResponse
    {

    }

    public function criteriaAction(): JsonResponse
    {

    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {

    }
}