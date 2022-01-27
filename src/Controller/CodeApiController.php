<?php

namespace Evrinoma\CodeBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Code\CodeInvalidException;
use Evrinoma\CodeBundle\Exception\Code\CodeNotFoundException;
use Evrinoma\CodeBundle\Manager\Code\CommandManagerInterface;
use Evrinoma\CodeBundle\Manager\Code\QueryManagerInterface;
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

final class CodeApiController extends AbstractApiController implements ApiControllerInterface
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
    private string $dtoClass;
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
     * @param string                  $dtoClass
     */
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
     * @Rest\Post("/api/code/create", options={"expose"=true}, name="api_code_create")
     * @OA\Post(
     *     tags={"code"},
     *     description="the method perform create code",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\CodeApiDto",
     *                  "brief":"DR",
     *                  "description":"Пылеудаление.",
     *                  "owner":{ "id":"3" },
     *                  "type":{ "id":"2" },
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\CodeApiDto"),
     *               @OA\Property(property="brief",type="string"),
     *               @OA\Property(property="description",type="string"),
     *               @OA\Property(property="owner",type="string",default="Evrinoma\CodeBundle\Dto\OnwerApiDto"),
     *               @OA\Property(property="type",type="string",default="Evrinoma\CodeBundle\Dto\TypeApiDto"),
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create code")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var CodeApiDtoInterface $codeApiDto */
        $codeApiDto     = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        $this->commandManager->setRestCreated();
        try {
            if ($codeApiDto->hasTypeApiDto() && $codeApiDto->getTypeApiDto()->hasId() && $codeApiDto->hasOwnerApiDto() && $codeApiDto->getOwnerApiDto()->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($codeApiDto, $commandManager, &$json) {
                        $json = $commandManager->post($codeApiDto);
                    }
                );
            } else {
                throw new CodeInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_code_code')->json(['message' => 'Create code code', 'data' => $json], $this->commandManager->getRestStatus());

    }

    /**
     * @Rest\Put("/api/code/save", options={"expose"=true}, name="api_code_save")
     * @OA\Put(
     *     tags={"code"},
     *     description="the method perform save code for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\CodeBundle\Dto\CodeApiDto",
     *                  "id":"3",
     *                  "active": "b",
     *                  "brief":"DR",
     *                  "description":"Пылеудаление.",
     *                  "owner":{ "id":"3" },
     *                  "type":{ "id":"2" },
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\CodeBundle\Dto\CodeApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="brief",type="string"),
     *               @OA\Property(property="description",type="string"),
     *               @OA\Property(property="owner",type="string",default="Evrinoma\CodeBundle\Dto\OnwerApiDto"),
     *               @OA\Property(property="type",type="string",default="Evrinoma\CodeBundle\Dto\TypeApiDto"),
     *               @OA\Property(property="active",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save code")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var CodeApiDtoInterface $codeApiDto */
        $codeApiDto     = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        try {
            if ($codeApiDto->hasId() && $codeApiDto->hasTypeApiDto() && $codeApiDto->getTypeApiDto()->hasId() && $codeApiDto->hasOwnerApiDto() && $codeApiDto->getOwnerApiDto()->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($codeApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($codeApiDto);
                    }
                );
            } else {
                    throw new CodeInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_code_code')->json(['message' => 'Save code coode', 'data' => $json], $this->commandManager->getRestStatus());


    }

    /**
     * @Rest\Delete("/api/code/delete", options={"expose"=true}, name="api_code_delete")
     * @OA\Delete(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\CodeApiDto",
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
     * @OA\Response(response=200,description="Delete code")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var CodeApiDtoInterface $codeApiDto */
        $codeApiDto     = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($codeApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();
                $em->transactional(
                    function () use ($codeApiDto, $commandManager, &$json) {
                        $commandManager->delete($codeApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new CodeInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete code code', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/code/criteria", options={"expose"=true}, name="api_code_criteria")
     * @OA\Get(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\CodeApiDto",
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
     *     ),
     *     @OA\Parameter(
     *         name="type[brief]",
     *         in="query",
     *         description="Type Bunch",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\CodeBundle\Form\Rest\CodeTypeChoiceType::class, options={"data":"brief"})
     *              ),
     *          ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="owner[brief]",
     *         in="query",
     *         description="Type Owner",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\CodeBundle\Form\Rest\CodeOwnerChoiceType::class, options={"data":"brief"})
     *              ),
     *          ),
     *         style="form"
     *     )
     * )
     * @OA\Response(response=200,description="Return code")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var CodeApiDtoInterface $codeApiDto */
        $codeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        try {
            $json = $this->queryManager->criteria($codeApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_code')->json(['message' => 'Get code code', 'data' => $json], $this->queryManager->getRestStatus());
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/code", options={"expose"=true}, name="api_code")
     * @OA\Get(
     *     tags={"code"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\CodeBundle\Dto\CodeApiDto",
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
     * @OA\Response(response=200,description="Return code")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var CodeApiDtoInterface $codeApiDto */
        $codeApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($codeApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_code_code')->json(['message' => 'Get code owner', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof CodeCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof CodeNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof CodeInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
//endregion Getters/Setters
}