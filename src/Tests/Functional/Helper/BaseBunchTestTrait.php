<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Helper;


use Evrinoma\CodeBundle\Tests\Functional\Action\Bunch\BaseBunch;
use Evrinoma\CodeBundle\Tests\Functional\Action\Type\BaseType;

trait BaseBunchTestTrait
{
//region SECTION: Protected
    protected function createBunch(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createBunchSecond(): array
    {
        $query = static::getDefault(["description" => "description"]);

        return $this->post($query);
    }

    protected function createConstraintBlankType(): array
    {
        $query = static::getDefault(['type' => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankDescription(): array
    {
        $query = static::getDefault(['description' => '']);

        return $this->post($query);
    }

    protected function createType(): array
    {
        $query = BaseType::defaultData();

        $this->postUrl = BaseType::API_POST;

        $type = $this->post($query);

        $this->postUrl = BaseBunch::API_POST;

        return $type;
    }
//endregion Protected
}