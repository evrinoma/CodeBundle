<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Action\Owner;

use Evrinoma\CodeBundle\Dto\OwnerApiDto;
use Evrinoma\CodeBundle\Tests\Functional\Helper\BaseOwnerTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use PHPUnit\Framework\Assert;

class BaseOwner extends AbstractServiceTest implements BaseOwnerTestInterface
{
    use BaseOwnerTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/owner';
    public const API_CRITERIA = 'evrinoma/api/code/owner/criteria';
    public const API_DELETE   = 'evrinoma/api/code/owner/delete';
    public const API_PUT      = 'evrinoma/api/code/owner/save';
    public const API_POST     = 'evrinoma/api/code/owner/create';
//endregion Fields

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "id"          => 1,
            "brief"       => "ipc",
            "description" => "desc",
            "class"       => static::getDtoClass(),
        ];
    }

    public function actionPost(): void
    {
        $created = $this->createOwner();
        $this->testResponseStatusCreated();
    }

    public function actionPut(): void
    {
        $created = $this->createOwner();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertTrue($created['data'] == $find['data']);

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => $find['data']['id'],
            "brief"       => "feirb",
            "description" => "noitpircsed",
        ];

        $this->put($query);
        $this->testResponseStatusOK();
    }

    public function actionCriteria(): void
    {
        $this->createOwner();
        $this->testResponseStatusCreated();
        $this->createOwnerSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "ipc"]);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "desc",]);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(2, $response['data']);
    }

    public function actionPutUnprocessable(): void
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

    public function actionCriteriaNotFound(): void
    {
        $this->createOwner();
        $this->testResponseStatusCreated();
        $this->createOwnerSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "ddoc"]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey('data', $response);
    }

    public function actionDelete(): void
    {
        $created = $this->createOwner();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        $response = $this->delete('1');
        $this->testResponseStatusAccepted();

        $delete = $this->get(1);
        $this->testResponseStatusNotFound();

        Assert::assertArrayHasKey('data', $delete);
        Assert::assertArrayHasKey('data', $response);
    }

    public function actionGet(): void
    {
        $created = $this->createOwner();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $find);

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertTrue($created['data'] == $find['data']);
    }

    public function actionPutNotFound(): void
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

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete('1');
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete('');
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(1);
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionPostDuplicate(): void
    {
        $this->createOwner();
        $this->testResponseStatusCreated();

        $this->createOwner();
        $this->testResponseStatusConflict();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankBrief();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankDescription();
        $this->testResponseStatusUnprocessable();
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return OwnerApiDto::class;
    }
//endregion Getters/Setters
}