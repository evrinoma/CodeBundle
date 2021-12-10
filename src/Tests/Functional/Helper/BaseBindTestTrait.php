<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Helper;


use PHPUnit\Framework\Assert;

trait BaseBindTestTrait
{
//region SECTION: Private
    private function assertGet(int $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    private function checkResult($entity): void
    {
        Assert::assertArrayHasKey('data', $entity);
        Assert::assertArrayHasKey('bunch', $entity['data']);
        Assert::assertArrayHasKey('code', $entity['data']);
        Assert::assertArrayHasKey('type', $entity['data']['bunch']);
        Assert::assertArrayHasKey('type', $entity['data']['code']);
    }

    private function createConstraintBlankBunch(): array
    {
        $query = static::getDefault(['bunch' => '']);

        return $this->post($query);
    }

    private function createConstraintBlankCode(): array
    {
        $query = static::getDefault(['code' => '']);

        return $this->post($query);
    }

    private function createCodeDuplicate(): array
    {
        $query = static::getDefault(['id' => 1]);

        return $this->post($query);
    }

    private function createCode(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }
//endregion Private
}