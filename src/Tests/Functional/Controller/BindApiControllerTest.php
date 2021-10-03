<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\BindApiDto;
use Evrinoma\CodeBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiHelperTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiHelperTestTrait;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class BindApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiHelperTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/bind';
    public const API_CRITERIA = 'evrinoma/api/code/bind/criteria';
    public const API_DELETE   = 'evrinoma/api/code/bind/delete';
    public const API_PUT      = 'evrinoma/api/code/bind/save';
    public const API_POST     = 'evrinoma/api/code/bind/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiHelperTestTrait;

//region SECTION: Protected
    protected static function getDtoClass(): string
    {
        return BindApiDto::class;
    }

    protected static function defaultData(): array
    {
//        return [
//            "id"          => 1,
//            "type"        => TypeApiControllerTest::defaultData(),
//            "description" => "desc",
//            "class"       => static::getDtoClass(),
//        ];
        return [];
    }

//endregion Protected
//region SECTION: Public
    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createConstraintBlankType();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createConstraintBlankDescription();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testGet(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertArrayHasKey('type', $created['data']);
        $this->assertArrayHasKey('type', $find['data']);

        $this->assertStringContainsString(serialize($created['data']), serialize($find['data']));
    }

    public function testDelete(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);
        $this->assertArrayHasKey('active', $find['data']);

        $this->delete('1');
        $this->assertEquals(Response::HTTP_ACCEPTED, $this->client->getResponse()->getStatusCode());

        $delete = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $delete);
        $this->assertArrayHasKey('active', $delete['data']);

        $this->assertEquals(ActiveModel::DELETED, $delete['data']['active']);
    }

    public function testPutUnprocessable(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => "",
            "description" => "0987654321",
            "type"        => TypeApiControllerTest::defaultData(),
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "type"        => TypeApiControllerTest::defaultData(),
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $query = [
            "id"          => "1",
            "description" => "0987654321",
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testCriteriaNotFound(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createBunchSecond();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "ddes"]);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
    }

    public function testPut(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertArrayHasKey('type', $created['data']);
        $this->assertArrayHasKey('type', $find['data']);

        $this->assertCount(0, array_diff($created['data']['type'], $find['data']['type']));

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => $find['data']['id'],
            "description" => "noitpircsed",
            "type"        => TypeApiControllerTest::defaultData(),
        ];

        $saved = $this->put($query);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $saved);
        $this->assertArrayHasKey('updated_at', $saved['data']);
    }

    public function testCriteria(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createBunchSecond();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "desc",]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);
    }

    public function testPutNotFound(): void
    {
        $this->put($this->getDefault(["description" => "0987654321",]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteNotFound(): void
    {
        $response = $this->delete('1');
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteUnprocessable(): void
    {
        $response = $this->delete('');
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testGetNotFound(): void
    {
        $response = $this->get(1);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testPostDuplicate(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->createBunch();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }
//endregion Public
}