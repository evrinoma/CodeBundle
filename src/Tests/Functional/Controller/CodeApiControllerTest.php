<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Evrinoma\CodeBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestTrait;
use Evrinoma\TestUtilsBundle\Helper\ResponseStatusTestTrait;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class CodeApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code';
    public const API_CRITERIA = 'evrinoma/api/code/criteria';
    public const API_DELETE   = 'evrinoma/api/code/delete';
    public const API_PUT      = 'evrinoma/api/code/save';
    public const API_POST     = 'evrinoma/api/code/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
    public static function getDtoClass(): string
    {
        return CodeApiDto::class;
    }

    public static function defaultData(): array
    {
        return [
            "id"          => 1,
            "owner"       => OwnerApiControllerTest::defaultData(),
            "type"        => TypeApiControllerTest::defaultData(),
            "brief"       => "brief code",
            "description" => "desc code",
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
        $this->init();

        $this->createCode();
        $this->testResponseStatusCreated();
    }

    public function testPut(): void
    {
        $this->init();

        $created = $this->createCode();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertStringContainsString(serialize($created['data']), serialize($find['data']));

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => $find['data']['id'],
            "description" => "noitpircsed",
            "brief"       => "edoc feirb",
            "owner"       => OwnerApiControllerTest::defaultData(),
            "type"        => TypeApiControllerTest::defaultData(),
        ];

        $saved = $this->put($query);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $saved);
        $this->assertArrayHasKey('updated_at', $saved['data']);
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankBrief();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankDescription();
        $this->testResponseStatusUnprocessable();
    }

    public function testPostDuplicate(): void
    {
        $this->init();

        $this->createCode();
        $this->testResponseStatusCreated();

        $this->createCode();
        $this->testResponseStatusConflict();
    }

    public function testGet(): void
    {
        $this->init();

        $created = $this->createCode();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertStringContainsString(serialize($created['data']), serialize($find['data']));
    }


    public function testDelete(): void
    {
        $this->init();

        $created = $this->createCode();
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
        $this->init();

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => "",
            "description" => "0987654321",
            "owner"       => OwnerApiControllerTest::defaultData(),
            "type"        => TypeApiControllerTest::defaultData(),
            "brief"       => "brief 0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createCode();
        $this->testResponseStatusCreated();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "owner"       => OwnerApiControllerTest::defaultData(),
            "type"        => TypeApiControllerTest::defaultData(),
            "brief"       => "brief 0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "brief"       => "brief 0987654321",
            "owner"       => OwnerApiControllerTest::defaultData(),
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "brief"       => "brief 0987654321",
            "type"        => TypeApiControllerTest::defaultData(),
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function testCriteriaNotFound(): void
    {
        $this->init();

        $this->createCode();
        $this->testResponseStatusCreated();
        $this->createCodeSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "ddes"]);
        $this->testResponseStatusNotFound();
        $this->assertArrayHasKey('data', $response);
    }

    public function testCriteria(): void
    {
        $this->init();

        $this->createCode();
        $this->testResponseStatusCreated();
        $this->createCodeSecond();
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

//endregion Public

//region SECTION: Private
    private function createCode(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    private function createCodeSecond(): array
    {
        $query = static::getDefault(["description" => "description"]);

        return $this->post($query);
    }

    private function createConstraintBlankBrief(): array
    {
        $query = static::getDefault(['brief' => '']);

        return $this->post($query);
    }

    private function createConstraintBlankDescription(): array
    {
        $query = static::getDefault(['description' => '']);

        return $this->post($query);
    }

    private function init(): void
    {
        $owner = $this->createOwner();
        $this->assertArrayHasKey('data', $owner);

        $type = $this->createType();
        $this->assertArrayHasKey('data', $type);
    }

    private function createOwner(): array
    {
        $query = OwnerApiControllerTest::defaultData();

        $this->postUrl = OwnerApiControllerTest::API_POST;

        $type = $this->post($query);

        $this->postUrl = CodeApiControllerTest::API_POST;

        return $type;
    }

    private function createType(): array
    {
        $query = TypeApiControllerTest::defaultData();

        $this->postUrl = TypeApiControllerTest::API_POST;

        $type = $this->post($query);

        $this->postUrl = CodeApiControllerTest::API_POST;

        return $type;
    }
}