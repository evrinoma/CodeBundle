<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\OwnerApiDto;
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
class OwnerApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiHelperTestInterface
{
    use ApiBrowserTestTrait, ApiHelperTestTrait;

//region SECTION: Protected
    protected function getDtoClass(): string
    {
        return OwnerApiDto::class;
    }

    protected function setDefault(): array
    {
        return [
            "id"          => 1,
            "brief"       => "ipc",
            "description" => "desc",
            "class"       => $this->getDtoClass(),
        ];
    }

//endregion Protected

//region SECTION: Public
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
            "class"       => $this->getDtoClass(),
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

        $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createTypeSecond();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => $this->getDtoClass(), "brief" => "ipc"]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);

        $response = $this->criteria(["class" => $this->getDtoClass(), "description" => "desc",]);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(2, $response['data']);
    }

    public function testPutUnprocessable(): void
    {
        $query = [
            "class"       => $this->getDtoClass(),
            "id"          => "",
            "brief"       => "ipc",
            "description" => "0987654321",
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());

        $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $query = [
            "id"          => "1",
            "brief"       => "ipc",
            "description" => "0987654321",
        ];

        $this->put($query);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $this->client->getResponse()->getStatusCode());
    }

    public function testCriteriaNotFound(): void
    {
        $this->createType();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->createTypeSecond();
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $response = $this->criteria(["class" => $this->getDtoClass(), "brief" => "ddoc"]);
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

    public function testPutNotFound(): void
    {
        $query = [
            "class"       => $this->getDtoClass(),
            "id"          => "1",
            "brief"       => "0987654321",
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

        $this->createConstraintBlankDescription();
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
        $query = $this->getDefault(['brief' => 'ipcng', "description" => "description"]);

        return $this->post($query);
    }

    private function createConstraintBlankBrief(): array
    {
        $query = $this->getDefault(['brief' => '']);

        return $this->post($query);
    }

    private function createConstraintBlankDescription(): array
    {
        $query = $this->getDefault(['description' => '']);

        return $this->post($query);
    }
//endregion Private

//region SECTION: Getters/Setters
    public function setUp(): void
    {
        parent::setUp();
        $this->getUrl      = 'evrinoma/api/code/owner';
        $this->criteriaUrl = 'evrinoma/api/code/owner/criteria';
        $this->deleteUrl   = 'evrinoma/api/code/owner/delete';
        $this->putUrl      = 'evrinoma/api/code/owner/save';
        $this->postUrl     = 'evrinoma/api/code/owner/create';
    }
//endregion Getters/Setters
}