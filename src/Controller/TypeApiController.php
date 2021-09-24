<?php

namespace Evrinoma\CodeBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerInvalidException;
use Evrinoma\Codebundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\Codebundle\Exception\Type\TypeInvalidException;
use Evrinoma\Codebundle\Exception\Type\TypeNotFoundException;
use Evrinoma\CodeBundle\Manager\Type\CommandManagerInterface;
use Evrinoma\CodeBundle\Manager\Type\QueryManagerInterface;
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

final class TypeApiController extends AbstractApiController implements ApiControllerInterface
{

//region SECTION: Fields
    private string $dtoClass = TypeApiDto::class;
    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var CommandManagerInterface|RestInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;
//endregion Fields

//region SECTION: Constructor
    public function __construct(SerializerInterface $serializer, RequestStack $requestStack, FactoryDtoInterface $factoryDto, CommandManagerInterface $commandManager, QueryManagerInterface $queryManager)
    {
        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->factoryDto     = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager   = $queryManager;
    }

//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Post("/api/code/type/create", options={"expose"=true}, name="api_create_code_type")
     * @OA\Post(
     *     tags={"code"},
     *     description="the method perform create code type",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\TypeApiDto",
     *                  "brief":"draft"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\TypeApiDto"),
     *               @OA\Property(property="brief",type="string"),
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
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        $this->commandManager->setRestCreated();
        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($typeApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($typeApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_code_type')->json(['message' => 'Create code type', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/code/type/save", options={"expose"=true}, name="api_save_code_type")
     * @OA\Put(
     *     tags={"code"},
     *     description="the method perform save code type for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\TypeApiDto",
     *                  "id":"3",
     *                  "brief":"draft"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\TypeApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="brief",type="string")
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
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        try {
            if ($typeApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($typeApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($typeApiDto);
                    }
                );
            } else {
                throw new TypeInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_code_type')->json(['message' => 'Save code type', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/code/type/delete", options={"expose"=true}, name="api_delete_code_type")
     * @OA\Delete(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\TypeApiDto",
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
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $commandManager   = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($typeApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($typeApiDto, $commandManager, &$json) {
                        $commandManager->delete($typeApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new OwnerInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete code type', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/code/type/criteria", options={"expose"=true}, name="api_code_type_criteria")
     * @OA\Get(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\TypeApiDto",
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
     *         description="brief",
     *         in="query",
     *         name="brief",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return code owners")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {

        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($typeApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_type')->json(['message' => 'Get code type', 'data' => $json], $this->queryManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/code/type", options={"expose"=true}, name="api_code_type")
     * @OA\Get(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\TypeApiDto",
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
     * @OA\Response(response=200,description="Return code types")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var TypeApiDtoInterface $typeApiDto */
        $typeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($typeApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_type')->json(['message' => 'Get code type', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof TypeCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof TypeNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof TypeInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
//endregion Public
}