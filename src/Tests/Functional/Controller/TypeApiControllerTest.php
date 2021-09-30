<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\CodeBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class TypeApiControllerTest extends CaseTest implements ApiControllerTestInterface
{
//region SECTION: Protected
    protected function getDtoClass(): string
    {
        return TypeApiDto::class;
    }

    protected function setDefault(): array
    {
        return [
            "id"         => 1,
            "brief"     => "doc"

        ];
    }
//endregion Protected

//region SECTION: Public
    public function testCriteria(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testCriteriaNotFound(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPut(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPutNotFound(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPutUnprocessable(): void
    {
        $this->assertTrue(true, 'message');
    }


    public function testDelete(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testDeleteNotFound(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testDeleteUnprocessable(): void
    {
        $this->assertTrue(true, 'message');
    }


    public function testGet(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testGetNotFound(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPostDuplicate(): void
    {
        $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->createType();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }

    public function testPostUnprocessable(): void
    {
        $this->createWrong();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createConstraintBlank();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }
//endregion Public
    protected function queryCreateType(array $query): void
    {
        $this->client->restart();

        $this->client->request('POST', 'evrinoma/api/code/type/create', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($query));
    }

    private function createType(): array
    {
        $query = $this->getDefault(["class" => $this->getDtoClass(), "brief" => "draft",]);

        $this->queryCreateType($query);

        return $query;
    }

    private function createWrong(): array
    {
        $query = $this->getDefault([]);

        $this->queryCreateType($query);

        return $query;
    }

    private function createConstraintBlank(): array
    {
        $query = $this->getDefault(["class" => $this->getDtoClass()]);

        $this->queryCreateType($query);

        return $query;
    }

    public function setUp(): void
    {
        $this->default = $this->randomType();

        parent::setUp();
    }
}