<?php

namespace Evrinoma\CodeBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchInvalidException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Manager\Bunch\CommandManagerInterface;
use Evrinoma\CodeBundle\Manager\Bunch\QueryManagerInterface;
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

final class BunchApiController extends AbstractApiController implements ApiControllerInterface
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
     * @Rest\Post("/api/code/bunch/create", options={"expose"=true}, name="api_create_code_bunch")
     * @OA\Post(
     *     tags={"code"},
     *     description="the method perform create code type",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\BunchApiDto",
     *                  "description":"Код типа чертежа",
     *                  "type":"2"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\BunchApiDto"),
     *               @OA\Property(property="description",type="string"),
     *               @OA\Property(property="type",type="string"),
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create code type")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var BunchApiDtoInterface $bunchApiDto */
        $bunchApiDto    = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        $this->commandManager->setRestCreated();
        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($bunchApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($bunchApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_code_bunch')->json(['message' => 'Create code bunch', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/code/bunch/save", options={"expose"=true}, name="api_save_code_bunch")
     * @OA\Put(
     *     tags={"code"},
     *     description="the method perform save code bunch for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\BunchApiDto",
     *                  "id":"3",
     *                  "description":"Код типа чертежа",
     *                  "active": "b",
     *                  "type":"2"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\BunchApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="description",type="string"),
     *               @OA\Property(property="type",type="string"),
     *               @OA\Property(property="active",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save code type")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var BunchApiDtoInterface $bunchApiDto */
        $bunchApiDto    = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        try {
            if ($bunchApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($bunchApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($bunchApiDto);
                    }
                );
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_code_bunch')->json(['message' => 'Save code bunch', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/code/bunch/delete", options={"expose"=true}, name="api_delete_code_bunch")
     * @OA\Delete(
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
     * @OA\Response(response=200,description="Delete code type")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var BunchApiDtoInterface $bunchApiDto */
        $bunchApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $commandManager = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($bunchApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($bunchApiDto, $commandManager, &$json) {
                        $commandManager->delete($bunchApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new BunchInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete code bunch', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/code/bunch/criteria", options={"expose"=true}, name="api_code_bunch_criteria")
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
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="description",
     *         in="query",
     *         name="description",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Type Bunch",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\CodeBundle\Form\Rest\TypeChoiceType::class)
     *              ),
     *          ),
     *         style="form"
     *     )
     * )
     * @OA\Response(response=200,description="Return code bunch")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var BunchApiDtoInterface $bunchApiDto */
        $bunchApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $this->queryManager->criteria($bunchApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_bunch')->json(['message' => 'Get code bunch', 'data' => $json], $this->queryManager->getRestStatus());
    }

//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/code/bunch", options={"expose"=true}, name="api_code_bunch")
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
     * @OA\Response(response=200,description="Return code bunch")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var BunchApiDtoInterface $bunchApiDto */
        $bunchApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $this->queryManager->get($bunchApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_bunch')->json(['message' => 'Get code bunch', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof BunchCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof BunchNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof BunchInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
//endregion Getters/Setters
}