<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\BunchApiDto;
use Evrinoma\CodeBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiHelperTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiHelperTestTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class BunchApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiHelperTestInterface
{
    use ApiBrowserTestTrait, ApiHelperTestTrait;

//region SECTION: Protected
    protected static function getDtoClass(): string
    {
        return BunchApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            "id"          => 1,
            "type"        => TypeApiControllerTest::defaultData(),
            "description" => "desc",
            "class"       => static::getDtoClass(),
        ];
    }

//endregion Protected
//region SECTION: Public
    public function testPut(): void
    {
        $type    = $this->createType();
        $created = $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $find);

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => $find['data']['id'],
            "brief"       => "feirb",
            "description" => "noitpircsed",
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testCriteria(): void
    {
        $query = $this->getDefault();

        $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createTypeSecond();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "desc",]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);
    }

    public function testPutUnprocessable(): void
    {
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
        $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createTypeSecond();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "description"]);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
    }

    public function testDelete(): void
    {
        $created = $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $response = $this->delete('1');
        $this->assertEquals(Response::HTTP_ACCEPTED, $this->client->getResponse()->getStatusCode());

        $delete = $this->get(1);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('data', $delete);
        $this->assertArrayHasKey('data', $response);
    }

    public function testGet(): void
    {
        $created = $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $find);

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));
    }

    public function testPutNotFound(): void
    {
        $query = [
            "class"       => static::getDtoClass(),
            "id"          => "1",
            "description" => "0987654321",
        ];

        $this->put($query);
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
        $this->createBunch();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->createBunch();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createConstraintBlankType();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createConstraintBlankDescription();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }
//endregion Public
//endregion Public

//region SECTION: Private
    private function createBunch(): array
    {
        $query = $this->getDefault();

        return $this->post($query);
    }

    private function createTypeSecond(): array
    {
        $query = $this->getDefault(["description" => "description"]);

        return $this->post($query);
    }

    private function createConstraintBlankType(): array
    {
        $query = $this->getDefault(['type' => '']);

        return $this->post($query);
    }

    private function createConstraintBlankDescription(): array
    {
        $query = $this->getDefault(['description' => '']);

        return $this->post($query);
    }

    private function createType(): array
    {
        $query = TypeApiControllerTest::defaultData();

        $baseUrl = static::$postUrl;
        static::$postUrl = 'evrinoma/api/code/type/create';
        $type =$this->post($query);
        static::$postUrl = $baseUrl;

        return $type;
    }
//endregion Private

//region SECTION: Getters/Setters
    public function setUp(): void
    {
        parent::setUp();
        static::$getUrl      = 'evrinoma/api/code/bunch';
        static::$criteriaUrl = 'evrinoma/api/code/bunch/criteria';
        static::$deleteUrl   = 'evrinoma/api/code/bunch/delete';
        static::$putUrl      = 'evrinoma/api/code/bunch/save';
        static::$postUrl     = 'evrinoma/api/code/bunch/create';
    }
//endregion Getters/Setters
}