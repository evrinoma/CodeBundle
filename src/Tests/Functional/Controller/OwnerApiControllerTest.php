<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\OwnerApiDto;
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
class OwnerApiControllerTest extends AbstractWebCaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
    public const API_GET      = 'evrinoma/api/code/owner';
    public const API_CRITERIA = 'evrinoma/api/code/owner/criteria';
    public const API_DELETE   = 'evrinoma/api/code/owner/delete';
    public const API_PUT      = 'evrinoma/api/code/owner/save';
    public const API_POST     = 'evrinoma/api/code/owner/create';

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
    public static function getDtoClass(): string
    {
        return OwnerApiDto::class;
    }

    public static function defaultData(): array
    {
        return [
            "id"          => 1,
            "brief"       => "ipc",
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
        $created = $this->createOwner();
        $this->testResponseStatusCreated();
    }

    public function testPut(): void
    {
        $created = $this->createOwner();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

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
        $this->testResponseStatusOK();
    }

    public function testCriteria(): void
    {
        $this->createOwner();
        $this->testResponseStatusCreated();
        $this->createOwnerSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "ipc"]);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "desc",]);
        $this->testResponseStatusOK();
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);
    }

    public function testPutUnprocessable(): void
    {
        $query = [
            "class"       => static::getDtoClass(),
            "id"          => "",
            "brief"       => "ipc",
            "description" => "0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createOwner();
        $this->testResponseStatusCreated();

        $query = [
            "id"          => "1",
            "brief"       => "ipc",
            "description" => "0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function testCriteriaNotFound(): void
    {
        $this->createOwner();
        $this->testResponseStatusCreated();
        $this->createOwnerSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "ddoc"]);
        $this->testResponseStatusNotFound();
        $this->assertArrayHasKey('data', $response);
    }

    public function testDelete(): void
    {
        $created = $this->createOwner();
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
        $created = $this->createOwner();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();
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
            "brief"       => "0987654321",
            "description" => "0987654321",
        ];

        $this->put($query);
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
        $this->createOwner();
        $this->testResponseStatusCreated();

        $this->createOwner();
        $this->testResponseStatusConflict();
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
//endregion Public

//region SECTION: Private
    private function createOwner(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    private function createOwnerSecond(): array
    {
        $query = static::getDefault(['brief' => 'ipcng', "description" => "description"]);

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
//endregion Private
}