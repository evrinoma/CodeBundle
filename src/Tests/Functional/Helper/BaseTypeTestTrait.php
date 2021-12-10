<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Helper;


trait BaseTypeTestTrait
{
//region SECTION: Protected
    protected function createType(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createTypeSecond(): array
    {
        $query = static::getDefault(['brief' => 'document']);

        return $this->post($query);
    }

    protected function createConstraintBlankBrief(): array
    {
        $query = static::getDefault(['brief' => '']);

        return $this->post($query);
    }
//endregion Protected
}