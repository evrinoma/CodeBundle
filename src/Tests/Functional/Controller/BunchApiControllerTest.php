<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\BunchApiDto;
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
class BunchApiControllerTest extends AbstractWebCaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/bunch';
    public const API_CRITERIA = 'evrinoma/api/code/bunch/criteria';
    public const API_DELETE   = 'evrinoma/api/code/bunch/delete';
    public const API_PUT      = 'evrinoma/api/code/bunch/save';
    public const API_POST     = 'evrinoma/api/code/bunch/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
    public static function getDtoClass(): string
    {
        return BunchApiDto::class;
    }

    public static function defaultData(): array
    {
        return [
            "id"          => 1,
            "type"        => TypeApiControllerTest::defaultData(),
            "description" => "desc",
            "class"       => static::getDtoClass(),
        ];
    }

    public static function getFixtures(): array
    {
        return [];
    }
//endregion Protected
//region SECTION: Public
    public function testPost(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->testResponseStatusCreated();
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankType();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankDescription();
        $this->testResponseStatusUnprocessable();
    }

    public function testGet(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

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
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);
        $this->assertArrayHasKey('active', $find['data']);

        $this->delete('1');
        $this->testResponseStatusAccepted();

        $delete = $this->get(1);
        $this->testResponseStatusOK();

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
        $this->testResponseStatusUnprocessable();

        $this->createBunch();
        $this->testResponseStatusCreated();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "type"        => TypeApiControllerTest::defaultData(),
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function testCriteriaNotFound(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->testResponseStatusCreated();
        $this->createBunchSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "ddes"]);
        $this->testResponseStatusNotFound();
        $this->assertArrayHasKey('data', $response);
    }

    public function testPut(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

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
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $saved);
        $this->assertArrayHasKey('updated_at', $saved['data']);
    }

    public function testCriteria(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->testResponseStatusCreated();
        $this->createBunchSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "desc",]);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);
    }

    public function testPutNotFound(): void
    {
        $this->put(static::getDefault(["description" => "0987654321",]));
        $this->testResponseStatusNotFound();
    }

    public function testDeleteNotFound(): void
    {
        $response = $this->delete('1');
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function testDeleteUnprocessable(): void
    {
        $response = $this->delete('');
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusUnprocessable();
    }

    public function testGetNotFound(): void
    {
        $response = $this->get(1);
        $this->assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function testPostDuplicate(): void
    {
        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->testResponseStatusCreated();

        $this->createBunch();
        $this->testResponseStatusConflict();
    }
//endregion Public

//region SECTION: Private
    private function createBunch(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    private function createBunchSecond(): array
    {
        $query = static::getDefault(["description" => "description"]);

        return $this->post($query);
    }

    private function createConstraintBlankType(): array
    {
        $query = static::getDefault(['type' => '']);

        return $this->post($query);
    }

    private function createConstraintBlankDescription(): array
    {
        $query = static::getDefault(['description' => '']);

        return $this->post($query);
    }

    private function createType(): array
    {
        $query = TypeApiControllerTest::defaultData();

        $this->postUrl = TypeApiControllerTest::API_POST;

        $type = $this->post($query);

        $this->postUrl = BunchApiControllerTest::API_POST;

        return $type;
    }
//endregion Private
}