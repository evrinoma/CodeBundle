<?php

namespace Evrinoma\CodeBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bind\BindInvalidException;
use Evrinoma\CodeBundle\Exception\Bind\BindNotFoundException;
use Evrinoma\CodeBundle\Manager\Bind\CommandManagerInterface;
use Evrinoma\CodeBundle\Manager\Bind\QueryManagerInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final class BindApiController extends AbstractApiController implements ApiControllerInterface
{
//region SECTION: Fields
    private string $dtoClass;
    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var CommandManagerInterface|RestInterface
     */
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

//region SECTION: Public
    /**
     * @Rest\Post("/api/code/bind/create", options={"expose"=true}, name="api_code_bind_create")
     * @OA\Post(
     *     tags={"code"},
     *     description="the method perform create code type",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\BindApiDto",
     *                  "bunch": {
     *                            "id":"2"
     *                       },
     *                  "code": {
     *                            "id":"1"
     *                       }
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\BindApiDto"),
     *               @OA\Property(property="bunch",type="string"),
     *               @OA\Property(property="code",type="string"),
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create code bind")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var BindApiDtoInterface $bindApiDto */
        $bindApiDto     = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        $this->commandManager->setRestCreated();
        try {
            if ($bindApiDto->hasBunchApiDto() && $bindApiDto->getBunchApiDto()->hasId() && $bindApiDto->hasCodeApiDto() && $bindApiDto->getCodeApiDto()->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($bindApiDto, $commandManager, &$json) {
                        $json = $commandManager->post($bindApiDto);
                    }
                );
            } else {
                throw new BindInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_code_bind')->json(['message' => 'Create code bind', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/code/bind/save", options={"expose"=true}, name="api_code_bind_save")
     * @OA\Put(
     *     tags={"code"},
     *     description="the method perform save code bind for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\BindApiDto",
     *                  "id":"3",
     *                  "active":"b",
     *                  "bunch": {
     *                            "id":"2"
     *                       },
     *                  "code": {
     *                            "id":"1"
     *                       }
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\BindApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="active",type="string"),
     *               @OA\Property(property="bunch",type="string"),
     *               @OA\Property(property="code",type="string"),
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save code bind")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var BindApiDtoInterface $bindApiDto */
        $bindApiDto     = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        try {
            if ($bindApiDto->hasId() && $bindApiDto->hasBunchApiDto() && $bindApiDto->getBunchApiDto()->hasId() && $bindApiDto->hasCodeApiDto() && $bindApiDto->getCodeApiDto()->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($bindApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($bindApiDto);
                    }
                );
            } else {
                throw new BindInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_code_bind')->json(['message' => 'Save code bind', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/code/bind/delete", options={"expose"=true}, name="api_code_bind_delete")
     * @OA\Delete(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\BindApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Delete code bind")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var BindApiDtoInterface $bindApiDto */
        $bindApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $commandManager = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($bindApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($bindApiDto, $commandManager, &$json) {
                        $commandManager->delete($bindApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new BindInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete code bind', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/code/bind/criteria", options={"expose"=true}, name="api_code_bind_criteria")
     * @OA\Get(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\BindApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="active",
     *         in="query",
     *         name="active",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="bunch[description]",
     *         in="query",
     *         description="Type Bunch",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\CodeBundle\Form\Rest\CodeBunchChoiceType::class, options={"data":"brief"})
     *              ),
     *          ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="code[brief]",
     *         in="query",
     *         description="Type Code Brief",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\CodeBundle\Form\Rest\CodeCodeChoiceType::class, options={"data":"brief"})
     *              ),
     *          ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="code[description]",
     *         in="query",
     *         description="Type Code Description",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\CodeBundle\Form\Rest\CodeCodeChoiceType::class, options={"data":"description"})
     *              ),
     *          ),
     *         style="form"
     *     )
     * )
     * @OA\Response(response=200,description="Return code bind")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var BindApiDtoInterface $bindApiDto */
        $bindApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($bindApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_bind')->json(['message' => 'Get code bind', 'data' => $json], $this->queryManager->getRestStatus());
    }

//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/code/bind", options={"expose"=true}, name="api_code_bind")
     * @OA\Get(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\BunchApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return code bind")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var BindApiDtoInterface $bindApiDto */
        $bindApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($bindApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_bind')->json(['message' => 'Get code bind', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof BindCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof BindNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof BindInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
//endregion Getters/Setters
}