<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\TypeApiDto;
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
class TypeApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiHelperTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/type';
    public const API_CRITERIA = 'evrinoma/api/code/type/criteria';
    public const API_DELETE   = 'evrinoma/api/code/type/delete';
    public const API_PUT      = 'evrinoma/api/code/type/save';
    public const API_POST     = 'evrinoma/api/code/type/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiHelperTestTrait;

//region SECTION: Protected
    public static function getDtoClass(): string
    {
        return TypeApiDto::class;
    }

    public static function defaultData(): array
    {
        return [
            "id"    => 1,
            "brief" => "doc",
            "class" => static::getDtoClass(),
        ];
    }

    protected function getFixtures(): array
    {
        return [];
    }
//endregion Protected

//region SECTION: Public
    public function testPost(): void
    {
        $created = $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testCriteria(): void
    {
        $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createTypeSecond();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "doc"]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "document"]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(1, $response['data']);
    }

    public function testCriteriaNotFound(): void
    {
        $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createTypeSecond();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "ddoc"]);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
    }

    public function testDelete(): void
    {
        $created = $this->createType();
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
        $created = $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $find);

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));
    }


    public function testPut(): void
    {
        $created = $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $find = $this->get(1);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $find);

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));

        $query = [
            "class" => static::getDtoClass(),
            "id"    => $find['data']['id'],
            "brief" => "brief",
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testPutNotFound(): void
    {
        $query = [
            "class" => static::getDtoClass(),
            "id"    => "1",
            "brief" => "0987654321",
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testPutUnprocessable(): void
    {
        $query = [
            "class" => static::getDtoClass(),
            "id"    => "",
            "brief" => "draft",
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $query = [
            "id"    => "1",
            "brief" => "draft",
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
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
        $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->createType();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createConstraintBlankBrief();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }
//endregion Public

//region SECTION: Private
    private function createType(): array
    {
        $query = $this->getDefault();

        return $this->post($query);
    }

    private function createTypeSecond(): array
    {
        $query = $this->getDefault(['brief' => 'document']);

        return $this->post($query);
    }

    private function createConstraintBlankBrief(): array
    {
        $query = $this->getDefault(['brief' => '']);

        return $this->post($query);
    }
//endregion Private
}