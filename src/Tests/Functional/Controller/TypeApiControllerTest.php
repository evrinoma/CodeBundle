<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestTrait;
use Evrinoma\TestUtilsBundle\Helper\ResponseStatusTestTrait;
use Evrinoma\TestUtilsBundle\Web\AbstractWebCaseTest;

/**
 * @group functional
 */
class TypeApiControllerTest extends AbstractWebCaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/type';
    public const API_CRITERIA = 'evrinoma/api/code/type/criteria';
    public const API_DELETE   = 'evrinoma/api/code/type/delete';
    public const API_PUT      = 'evrinoma/api/code/type/save';
    public const API_POST     = 'evrinoma/api/code/type/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
//endregion Protected

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "id"    => 1,
            "brief" => "doc",
            "class" => static::getDtoClass(),
        ];
    }

    public function testPost(): void
    {
        $created = $this->createType();
        $this->testResponseStatusCreated();
    }

    public function testCriteria(): void
    {
        $this->createType();
        $this->testResponseStatusCreated();
        $this->createTypeSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "doc"]);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "document"]);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(1, $response['data']);
    }

    public function testCriteriaNotFound(): void
    {
        $this->createType();
        $this->testResponseStatusCreated();
        $this->createTypeSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "ddoc"]);
        $this->testResponseStatusNotFound();
        $this->assertArrayHasKey('data', $response);
    }

    public function testDelete(): void
    {
        $created = $this->createType();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $response = $this->delete('1');
        $this->testResponseStatusAccepted();

        $delete = $this->get(1);
        $this->testResponseStatusNotFound();

        $this->assertArrayHasKey('data', $delete);
        $this->assertArrayHasKey('data', $response);
    }

    public function testGet(): void
    {
        $created = $this->createType();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $find);

        $this->assertArrayHasKey('data', $created);
        $this->assertArrayHasKey('data', $find);

        $this->assertCount(0, array_diff($created['data'], $find['data']));
    }

    public function testPut(): void
    {
        $created = $this->createType();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();
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
        $this->testResponseStatusOK();
    }

    public function testPutNotFound(): void
    {
        $query = [
            "class" => static::getDtoClass(),
            "id"    => "1",
            "brief" => "0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusNotFound();
    }

    public function testPutUnprocessable(): void
    {
        $query = [
            "class" => static::getDtoClass(),
            "id"    => "",
            "brief" => "draft",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createType();
        $this->testResponseStatusCreated();

        $query = [
            "id"    => "1",
            "brief" => "draft",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
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
        $this->createType();
        $this->testResponseStatusCreated();

        $this->createType();
        $this->testResponseStatusConflict();
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankBrief();
        $this->testResponseStatusUnprocessable();
    }
//endregion Public

//region SECTION: Private
    private function createType(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    private function createTypeSecond(): array
    {
        $query = static::getDefault(['brief' => 'document']);

        return $this->post($query);
    }

    private function createConstraintBlankBrief(): array
    {
        $query = static::getDefault(['brief' => '']);

        return $this->post($query);
    }
//endregion Private

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return TypeApiDto::class;
    }

    public static function getFixtures(): array
    {
        return [];
    }
//endregion Getters/Setters
}