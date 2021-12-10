<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Helper;


trait BaseOwnerTestTrait
{
    protected function createOwner(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createOwnerSecond(): array
    {
        $query = static::getDefault(['brief' => 'ipcng', "description" => "description"]);

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
}