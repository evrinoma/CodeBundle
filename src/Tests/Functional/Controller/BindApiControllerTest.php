<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\BindApiDto;
use Evrinoma\CodeBundle\Fixtures\FixtureInterface;
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
    public static function getDtoClass(): string
    {
        return BindApiDto::class;
    }

    protected function getFixtures(): array
    {
        return [FixtureInterface::BIND_FIXTURES];
    }

    public static function defaultData(): array
    {
        return [
            "id"     => 9,
            "bunch"  => BunchApiControllerTest::defaultData(),
            "code"   => CodeApiControllerTest::defaultData(),
            "active" => "a",
            "class"  => static::getDtoClass(),
        ];
    }

//endregion Protected
//region SECTION: Public
    public function testPost(): void
    {
        $created = $this->createCode();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testCriteria(): void
    {
        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD', "description" => 'sdf'], "bunch" => ["description" => 'ca'] ]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertCount(1, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "d"]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertCount(3, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "bunch" => ["description" => 'ca'] ]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertCount(4, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["description" => 'asd'] ]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertCount(2, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD'] ]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertCount(2, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD'], "bunch" => ["description" => 'ca'] ]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertCount(1, $find['data']);
    }

    public function testCriteriaNotFound(): void
    {
        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "b"]);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $find);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD', "description" => 'sdf'], "bunch" => ["description" => 'v'] ]);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $find);
    }

    public function testPut(): void
    {
        $find = $this->assertGet(6);

        $updated = $this->put($this->getDefault(['id' => 6, 'code' => ['id' => 4]]));
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertNotEquals($find['data']['code']['id'], $updated['data']['code']['id']);
        $this->assertEquals(4, $updated['data']['code']['id']);

        $findUpdated = $this->assertGet(6);
        $this->assertStringContainsString(serialize($updated['data']), serialize($findUpdated['data']));
    }

    public function testPutUnprocessable(): void
    {
        $query = $this->getDefault(['id' => '']);

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $query = $this->getDefault(['bunch' => '']);

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $bunch       = BunchApiControllerTest::defaultData();
        $bunch['id'] = '';
        $query       = $this->getDefault(['bunch' => $bunch]);

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $query = $this->getDefault(['code' => '']);

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $code       = CodeApiControllerTest::defaultData();
        $code['id'] = '';

        $query = $this->getDefault(['code' => $code]);

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testPutNotFound(): void
    {
        $this->put($this->getDefault(["id" => 100, "description" => "0987654321",]));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteNotFound(): void
    {
        $response = $this->delete(100);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testDelete(): void
    {
        $find = $this->assertGet(2);

        $this->assertEquals(ActiveModel::ACTIVE, $find['data']['active']);

        $this->delete(2);
        $this->assertEquals(Response::HTTP_ACCEPTED, $this->client->getResponse()->getStatusCode());

        $delete = $this->assertGet(2);

        $this->assertEquals(ActiveModel::DELETED, $delete['data']['active']);
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createConstraintBlankBunch();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createConstraintBlankCode();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testPostDuplicate(): void
    {
        $created = $this->createCode();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createCodeDuplicate();
        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }

    public function testGetNotFound(): void
    {
        $response = $this->get(100);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteUnprocessable(): void
    {
        $response = $this->delete('');
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testGet(): void
    {
        $find = $this->assertGet(1);

        $this->assertStringContainsString(serialize($find['data']['bunch']['type']), serialize($find['data']['code']['type']));
    }
//endregion Public

//region SECTION: Private
    private function assertGet(int $id): array
    {
        $find = $this->get($id);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->checkResult($find);

        return $find;
    }

    private function checkResult($entity):void
    {
        $this->assertArrayHasKey('data', $entity);
        $this->assertArrayHasKey('bunch', $entity['data']);
        $this->assertArrayHasKey('code', $entity['data']);
        $this->assertArrayHasKey('type', $entity['data']['bunch']);
        $this->assertArrayHasKey('type', $entity['data']['code']);
    }

    private function createConstraintBlankBunch(): array
    {
        $query = $this->getDefault(['bunch' => '']);

        return $this->post($query);
    }

    private function createConstraintBlankCode(): array
    {
        $query = $this->getDefault(['code' => '']);

        return $this->post($query);
    }

    private function createCodeDuplicate(): array
    {
        $query = $this->getDefault(['id' => 1]);

        return $this->post($query);
    }

    private function createCode(): array
    {
        $query = $this->getDefault();

        return $this->post($query);
    }
//endregion Private

}