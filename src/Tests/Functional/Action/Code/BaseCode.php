<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Action\Code;

use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Evrinoma\CodeBundle\Tests\Functional\Action\Owner\BaseOwner;
use Evrinoma\CodeBundle\Tests\Functional\Action\Type\BaseType;
use Evrinoma\CodeBundle\Tests\Functional\Helper\BaseCodeTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use PHPUnit\Framework\Assert;

class BaseCode extends AbstractServiceTest implements BaseCodeTestInterface
{
    use BaseCodeTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code';
    public const API_CRITERIA = 'evrinoma/api/code/criteria';
    public const API_DELETE   = 'evrinoma/api/code/delete';
    public const API_PUT      = 'evrinoma/api/code/save';
    public const API_POST     = 'evrinoma/api/code/create';
//endregion Fields

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "id"          => 1,
            "owner"       => BaseOwner::defaultData(),
            "type"        => BaseType::defaultData(),
            "brief"       => "brief code",
            "description" => "desc code",
            "class"       => static::getDtoClass(),
        ];
    }

    public function actionPost(): void
    {
        $this->init();

        $this->createCode();
        $this->testResponseStatusCreated();
    }

    public function actionPut(): void
    {
        $this->init();

        $created = $this->createCode();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertStringContainsString(serialize($created['data']), serialize($find['data']));

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => $find['data']['id'],
            "description" => "noitpircsed",
            "brief"       => "edoc feirb",
            "owner"       => BaseOwner::defaultData(),
            "type"        => BaseType::defaultData(),
        ];

        $saved = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $saved);
        Assert::assertArrayHasKey('updated_at', $saved['data']);
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

    public function actionPostDuplicate(): void
    {
        $this->init();

        $this->createCode();
        $this->testResponseStatusCreated();

        $this->createCode();
        $this->testResponseStatusConflict();
    }

    public function actionGet(): void
    {
        $this->init();

        $created = $this->createCode();
        $this->testResponseStatusCreated();

        $find = $this->get(1);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $created);
        Assert::assertArrayHasKey('data', $find);

        Assert::assertStringContainsString(serialize($created['data']), serialize($find['data']));
    }

    public function actionDelete(): void
    {
        $this->init();

        $created = $this->createCode();
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
        $this->init();

        $query = [
            "class"       => static::getDtoClass(),
            "id"          => "",
            "description" => "0987654321",
            "owner"       => BaseOwner::defaultData(),
            "type"        => BaseType::defaultData(),
            "brief"       => "brief 0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createCode();
        $this->testResponseStatusCreated();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "owner"       => BaseOwner::defaultData(),
            "type"        => BaseType::defaultData(),
            "brief"       => "brief 0987654321",
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "brief"       => "brief 0987654321",
            "owner"       => BaseOwner::defaultData(),
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = [
            "id"          => "1",
            "description" => "0987654321",
            "brief"       => "brief 0987654321",
            "type"        => BaseType::defaultData(),
        ];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionCriteriaNotFound(): void
    {
        $this->init();

        $this->createCode();
        $this->testResponseStatusCreated();
        $this->createCodeSecond();
        $this->testResponseStatusCreated();

        $response = $this->criteria(["class" => static::getDtoClass(), "description" => "ddes"]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey('data', $response);
    }

    public function actionCriteria(): void
    {
        $this->init();

        $this->createCode();
        $this->testResponseStatusCreated();
        $this->createCodeSecond();
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
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return CodeApiDto::class;
    }
//endregion Getters/Setters
}