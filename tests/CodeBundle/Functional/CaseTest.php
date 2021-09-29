<?php

namespace Evrinoma\CodeBundle\Tests\Functional;

use Evrinoma\TestUtilsBundle\Web\AbstractWebCaseTest;

/**
 * TestCase.
 */
abstract class CaseTest extends AbstractWebCaseTest
{

//region SECTION: Fields
    protected array $default = [];
//endregion Fields

//region SECTION: Protected

    protected function getDefault(array $extend): array
    {
        return array_merge($extend, unserialize(serialize($this->default)));
    }

    abstract protected function getDtoClass(): string;

    /**
     * {@inheritdoc}
     */
    protected static function createKernel(array $options = [])
    {
        require_once __DIR__.'/Kernel.php';

        return new Kernel('test', true);
    }
//endregion Protected
}
