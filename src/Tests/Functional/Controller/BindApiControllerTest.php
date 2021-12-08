<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\BindApiDto;
use Evrinoma\CodeBundle\Fixtures\FixtureInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestTrait;
use Evrinoma\TestUtilsBundle\Helper\ResponseStatusTestTrait;
use Evrinoma\TestUtilsBundle\Web\AbstractWebCaseTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;

/**
 * @group functional
 */
class BindApiControllerTest extends AbstractWebCaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/bind';
    public const API_CRITERIA = 'evrinoma/api/code/bind/criteria';
    public const API_DELETE   = 'evrinoma/api/code/bind/delete';
    public const API_PUT      = 'evrinoma/api/code/bind/save';
    public const API_POST     = 'evrinoma/api/code/bind/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
    public static function getDtoClass(): string
    {
        return BindApiDto::class;
    }

    public static function getFixtures(): array
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
        $this->testResponseStatusCreated();
    }

    public function testCriteria(): void
    {
        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD', "description" => 'sdf'], "bunch" => ["description" => 'ca'] ]);
        $this->testResponseStatusOK();
        $this->assertCount(1, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "d"]);
        $this->testResponseStatusOK();
        $this->assertCount(3, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "bunch" => ["description" => 'ca'] ]);
        $this->testResponseStatusOK();
        $this->assertCount(4, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["description" => 'asd'] ]);
        $this->testResponseStatusOK();
        $this->assertCount(2, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD'] ]);
        $this->testResponseStatusOK();
        $this->assertCount(2, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD'], "bunch" => ["description" => 'ca'] ]);
        $this->testResponseStatusOK();
        $this->assertCount(1, $find['data']);
    }

    public function testCriteriaNotFound(): void
    {
        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "b"]);
        $this->testResponseStatusNotFound();
        $this->assertArrayHasKey('data', $find);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD', "description" => 'sdf'], "bunch" => ["description" => 'v'] ]);
        $this->testResponseStatusNotFound();
        $this->assertArrayHasKey('data', $find);
    }

    public function testPut(): void
    {
        $find = $this->assertGet(6);

        $updated = $this->put(static::getDefault(['id' => 6, 'code' => ['id' => 4]]));
        $this->testResponseStatusOK();

        $this->assertNotEquals($find['data']['code']['id'], $updated['data']['code']['id']);
        $this->assertEquals(4, $updated['data']['code']['id']);

        $findUpdated = $this->assertGet(6);
        $this->assertStringContainsString(serialize($updated['data']), serialize($findUpdated['data']));
    }

    public function testPutUnprocessable(): void
    {
        $query = static::getDefault(['id' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault(['bunch' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $bunch       = BunchApiControllerTest::defaultData();
        $bunch['id'] = '';
        $query       = static::getDefault(['bunch' => $bunch]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault(['code' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $code       = CodeApiControllerTest::defaultData();
        $code['id'] = '';

        $query = static::getDefault(['code' => $code]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function testPutNotFound(): void
    {
        $this->put(static::getDefault(["id" => 100, "description" => "0987654321",]));
        $this->testResponseStatusNotFound();
    }

    public function testDeleteNotFound(): void
    {
        $response = $this->delete(100);
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function testDelete(): void
    {
        $find = $this->assertGet(2);

        $this->assertEquals(ActiveModel::ACTIVE, $find['data']['active']);

        $this->delete(2);
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(2);

        $this->assertEquals(ActiveModel::DELETED, $delete['data']['active']);
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankBunch();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankCode();
        $this->testResponseStatusUnprocessable();
    }

    public function testPostDuplicate(): void
    {
        $created = $this->createCode();
        $this->testResponseStatusCreated();
        $this->createCodeDuplicate();
        $this->testResponseStatusConflict();
    }

    public function testGetNotFound(): void
    {
        $response = $this->get(100);
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function testDeleteUnprocessable(): void
    {
        $response = $this->delete('');
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusUnprocessable();
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
        $this->testResponseStatusOK();

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
        $query = static::getDefault(['bunch' => '']);

        return $this->post($query);
    }

    private function createConstraintBlankCode(): array
    {
        $query = static::getDefault(['code' => '']);

        return $this->post($query);
    }

    private function createCodeDuplicate(): array
    {
        $query = static::getDefault(['id' => 1]);

        return $this->post($query);
    }

    private function createCode(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }
//endregion Private

}