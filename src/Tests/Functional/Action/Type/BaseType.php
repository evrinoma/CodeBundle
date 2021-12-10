<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Action\Type;

use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\CodeBundle\Tests\Functional\Helper\BaseTypeTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use PHPUnit\Framework\Assert;

class BaseType extends AbstractServiceTest implements BaseTypeTestInterface
{
    use BaseTypeTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/type';
    public const API_CRITERIA = 'evrinoma/api/code/type/criteria';
    public const API_DELETE   = 'evrinoma/api/code/type/delete';
    public const API_PUT      = 'evrinoma/api/code/type/save';
    public const API_POST     = 'evrinoma/api/code/type/create';
//endregion Fields

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "id"    => 1,
            "brief" => "doc",
            "class" => static::getDtoClass(),
        ];
    }

    public function actionPost(): void
    {
        $created = $this->createType();
        $this->testResponseStatusCreated();
    }

    public function actionCriteria(): void
    {
        $this->createType();
        $this->testResponseStatusCreated();
        $this->createTypeSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "doc"]);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(2, $response['data']);

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "document"]);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
    }

    public function actionCriteriaNotFound(): void
    {
        $this->createType();
        $this->testResponseStatusCreated();
        $this->createTypeSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "brief" => "ddoc"]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey('data', $response);
    }

    public function actionDelete(): void
    {
        $created = $this->createType();
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
        $created = $this->createType();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $find);

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertCount(0, array_diff($created['data'], $find['data']));
    }

    public function actionPut(): void
    {
        $created = $this->createType();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $find);

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertCount(0, array_diff($created['data'], $find['data']));

        $query = [
            "class" => static::getDtoClass(),
            "id"    => $find['data']['id'],
            "brief" => "brief",
        ];

        $this->put($query);
        $this->testResponseStatusOK();
    }

    public function actionPutNotFound(): void
    {
        $query = [
            "class" => static::getDtoClass(),
            "id"    => "1",
            "brief" => "0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
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
        $this->createType();
        $this->testResponseStatusCreated();

        $this->createType();
        $this->testResponseStatusConflict();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankBrief();
        $this->testResponseStatusUnprocessable();
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return TypeApiDto::class;
    }
//endregion Getters/Setters
//endregion Public
}