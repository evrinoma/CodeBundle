<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Action\Bind;

use Evrinoma\CodeBundle\Dto\BindApiDto;
use Evrinoma\CodeBundle\Tests\Functional\Action\Bunch\BaseBunch;
use Evrinoma\CodeBundle\Tests\Functional\Action\Code\BaseCode;
use Evrinoma\CodeBundle\Tests\Functional\Helper\BaseBindTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use PHPUnit\Framework\Assert;

class BaseBind extends AbstractServiceTest implements BaseBindTestInterface
{
    use BaseBindTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/code/bind';
    public const API_CRITERIA = 'evrinoma/api/code/bind/criteria';
    public const API_DELETE   = 'evrinoma/api/code/bind/delete';
    public const API_PUT      = 'evrinoma/api/code/bind/save';
    public const API_POST     = 'evrinoma/api/code/bind/create';
//endregion Fields

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "id"     => 9,
            "bunch"  => BaseBunch::defaultData(),
            "code"   => BaseCode::defaultData(),
            "active" => "a",
            "class"  => static::getDtoClass(),
        ];
    }

    public function actionPost(): void
    {
        $created = $this->createCode();
        $this->testResponseStatusCreated();
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD', "description" => 'sdf'], "bunch" => ["description" => 'ca']]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "d"]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "bunch" => ["description" => 'ca']]);
        $this->testResponseStatusOK();
        Assert::assertCount(4, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["description" => 'asd']]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD']]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find['data']);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD'], "bunch" => ["description" => 'ca']]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find['data']);
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "b"]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey('data', $find);

        $find = $this->criteria(["class" => static::getDtoClass(), "active" => "a", "code" => ["brief" => 'KD', "description" => 'sdf'], "bunch" => ["description" => 'v']]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey('data', $find);
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(6);

        $updated = $this->put(static::getDefault(['id' => 6, 'code' => ['id' => 4]]));
        $this->testResponseStatusOK();

        Assert::assertNotEquals($find['data']['code']['id'], $updated['data']['code']['id']);
        Assert::assertEquals(4, $updated['data']['code']['id']);

        $findUpdated = $this->assertGet(6);
        Assert::assertStringContainsString(serialize($updated['data']), serialize($findUpdated['data']));
    }

    public function actionPutUnprocessable(): void
    {
        $query = static::getDefault(['id' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault(['bunch' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $bunch       = BaseBunch::defaultData();
        $bunch['id'] = '';
        $query       = static::getDefault(['bunch' => $bunch]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault(['code' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $code       = BaseCode::defaultData();
        $code['id'] = '';

        $query = static::getDefault(['code' => $code]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault(["id" => 100, "description" => "0987654321",]));
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(100);
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(2);

        Assert::assertEquals(ActiveModel::ACTIVE, $find['data']['active']);

        $this->delete(2);
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(2);

        Assert::assertEquals(ActiveModel::DELETED, $delete['data']['active']);
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankBunch();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankCode();
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createCode();
        $this->testResponseStatusCreated();
        $this->createCodeDuplicate();
        $this->testResponseStatusConflict();
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(100);
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete('');
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(1);

        Assert::assertStringContainsString(serialize($find['data']['bunch']['type']), serialize($find['data']['code']['type']));
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return BindApiDto::class;
    }
//endregion Getters/Setters
}