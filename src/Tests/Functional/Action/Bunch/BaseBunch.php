<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Action\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDto;
use Evrinoma\CodeBundle\Tests\Functional\Action\Type\BaseType;
use Evrinoma\CodeBundle\Tests\Functional\Helper\BaseBunchTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use PHPUnit\Framework\Assert;

class BaseBunch extends AbstractServiceTest implements BaseBunchTestInterface
{
    use BaseBunchTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/bunch';
    public const API_CRITERIA = 'evrinoma/api/code/bunch/criteria';
    public const API_DELETE   = 'evrinoma/api/code/bunch/delete';
    public const API_PUT      = 'evrinoma/api/code/bunch/save';
    public const API_POST     = 'evrinoma/api/code/bunch/create';
//endregion Fields

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "id"          => 1,
            "type"        => BaseType::defaultData(),
            "description" => "desc",
            "class"       => static::getDtoClass(),
        ];
    }

    public function actionPost(): void
    {
        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->testResponseStatusCreated();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankType();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankDescription();
        $this->testResponseStatusUnprocessable();
    }

    public function actionGet(): void
    {
        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertArrayHasKey('type', $created['data']);
        Assert::assertArrayHasKey('type', $find['data']);

        Assert::assertStringContainsString(serialize($created['data']), serialize($find['data']));
    }

    public function actionDelete(): void
    {
        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);
        Assert::assertArrayHasKey('active', $find['data']);

        $this->delete('1');
        $this->testResponseStatusAccepted();

        $delete = $this->get(1);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $delete);
        Assert::assertArrayHasKey('active', $delete['data']);

        Assert::assertEquals(ActiveModel::DELETED, $delete['data']['active']);
    }

    public function actionPutUnprocessable(): void
    {
        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => "",
            "description" => "0987654321",
            "type"        => BaseType::defaultData(),
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createBunch();
        $this->testResponseStatusCreated();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "type"        => BaseType::defaultData(),
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

    public function actionCriteriaNotFound(): void
    {
        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->testResponseStatusCreated();
        $this->createBunchSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "ddes"]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey('data', $response);
    }

    public function actionPut(): void
    {
        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);

        $created = $this->createBunch();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertArrayHasKey('type', $created['data']);
        Assert::assertArrayHasKey('type', $find['data']);

        Assert::assertCount(0, array_diff($created['data']['type'], $find['data']['type']));

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => $find['data']['id'],
            "description" => "noitpircsed",
            "type"        => BaseType::defaultData(),
        ];

        $saved = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $saved);
        Assert::assertArrayHasKey('updated_at', $saved['data']);
    }

    public function actionCriteria(): void
    {
        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->testResponseStatusCreated();
        $this->createBunchSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "desc",]);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(2, $response['data']);
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault(["description" => "0987654321",]));
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
        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);

        $this->createBunch();
        $this->testResponseStatusCreated();

        $this->createBunch();
        $this->testResponseStatusConflict();
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return BunchApiDto::class;
    }
//endregion Getters/Setters
}