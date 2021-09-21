<?php

namespace Evrinoma\CodeBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\CodeBundle\Dto\OwnerApiDto;
use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerInvalidException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Manager\Owner\CommandManagerInterface;
use Evrinoma\CodeBundle\Manager\Owner\QueryManagerInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;

final class OwnerApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;
    /**
     * @var CommandManagerInterface|RestInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var string
     */
    private string $dtoClass = OwnerApiDto::class;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param SerializerInterface     $serializer
     * @param RequestStack            $requestStack
     * @param FactoryDtoInterface     $factoryDto
     * @param CommandManagerInterface $commandManager
     * @param QueryManagerInterface   $queryManager
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        CommandManagerInterface $commandManager,
        QueryManagerInterface $queryManager
    ) {
        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->factoryDto     = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager   = $queryManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Post("/api/code/owner/create", options={"expose"=true}, name="api_create_code_owner")
     * @OA\Post(
     *     tags={"code"},
     *     description="the method perform create code owner",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\CodeOwnerApiDto",
     *                  "brief":"ipc",
     *                  "description": "ИПЦ"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\CodeOwnerApiDto"),
     *               @OA\Property(property="brief",type="string"),
     *               @OA\Property(property="description",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create code owner")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var OwnerApiDtoInterface $codeOwnerApiDto */
        $codeOwnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;

        $this->commandManager->setRestCreated();
        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($codeOwnerApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($codeOwnerApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_code_owner')->json(['message' => 'Create code owner', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/code/owner/save", options={"expose"=true}, name="api_save_code_owner")
     * @OA\Put(
     *     tags={"code"},
     *     description="the method perform save code owner for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\CodeOwnerApiDto",
     *                  "id":"3",
     *                  "brief":"ipc",
     *                  "description": "ИПЦ"
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\CodeOwnerApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="brief",type="string"),
     *               @OA\Property(property="description",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save code owner")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var OwnerApiDtoInterface $codeOwnerApiDto */
        $codeOwnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager   = $this->commandManager;

        try {
            if ($codeOwnerApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($codeOwnerApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($codeOwnerApiDto);
                    }
                );
            } else {
                throw new OwnerInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_code_owner')->json(['message' => 'Save code owner', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/code/owner/delete", options={"expose"=true}, name="api_delete_code_owner")
     * @OA\Delete(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\CodeOwnerApiDto",
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
     * @OA\Response(response=200,description="Delete code owner")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var OwnerApiDtoInterface $codeOwnerApiDto */
        $codeOwnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $commandManager   = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($codeOwnerApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($codeOwnerApiDto, $commandManager, &$json) {
                        $commandManager->delete($codeOwnerApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new OwnerInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete code owner', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/code/owner/criteria", options={"expose"=true}, name="api_code_owner_criteria")
     * @OA\Get(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\CodeOwnerApiDto",
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
     *     ),
     *      @OA\Parameter(
     *         description="description",
     *         in="query",
     *         name="description",
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

        /** @var OwnerApiDtoInterface $codeOwnerApiDto */
        $codeOwnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($codeOwnerApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_owner')->json(['message' => 'Get code owner', 'data' => $json], $this->queryManager->getRestStatus());
    }
//endregion Public

//region SECTION: Private
    private function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof OwnerCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof OwnerNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof OwnerInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/code/owner", options={"expose"=true}, name="api_code_owner")
     * @OA\Get(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\CodeOwnerApiDto",
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
     * @OA\Response(response=200,description="Return code owners")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var OwnerApiDtoInterface $codeOwnerApiDto */
        $codeOwnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($codeOwnerApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_owner')->json(['message' => 'Get code owner', 'data' => $json], $this->queryManager->getRestStatus());
    }
//endregion Constructor
}