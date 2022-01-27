<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Helper;


use Evrinoma\CodeBundle\Tests\Functional\Action\Code\BaseCode;
use Evrinoma\CodeBundle\Tests\Functional\Action\Owner\BaseOwner;
use Evrinoma\CodeBundle\Tests\Functional\Action\Type\BaseType;
use PHPUnit\Framework\Assert;

trait BaseCodeTestTrait
{
//region SECTION: Protected
    protected function createCode(): array
    {
        $query = static::getDefault(["id" => '']);

        return $this->post($query);
    }

    protected function createCodeSecond(): array
    {
        $query = static::getDefault(["description" => "description"]);

        return $this->post($query);
    }

    protected function createConstraintBlankBrief(): array
    {
        $query = static::getDefault(['brief' => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankDescription(): array
    {
        $query = static::getDefault(['description' => '']);

        return $this->post($query);
    }

    protected function init(): void
    {
        $owner = $this->createOwner();
        Assert::assertArrayHasKey('data', $owner);

        $type = $this->createType();
        Assert::assertArrayHasKey('data', $type);
    }

    protected function createOwner(): array
    {
        $query = BaseOwner::defaultData();

        $this->postUrl = BaseOwner::API_POST;

        $type = $this->post($query);

        $this->postUrl = BaseCode::API_POST;

        return $type;
    }

    protected function createType(): array
    {
        $query = BaseType::defaultData();

        $this->postUrl = BaseType::API_POST;

        $type = $this->post($query);

        $this->postUrl = BaseCode::API_POST;

        return $type;
    }
//endregion Protected
}