<?php

namespace Evrinoma\CodeBundle\Tests\Functional;

use Evrinoma\TestUtilsBundle\Kernel\AbstractApiKernel;

/**
 * Kernel
 */
class Kernel extends AbstractApiKernel
{
//region SECTION: Fields
    protected string $bundlePrefix = 'CodeBundle';
    protected string $rootDir = __DIR__;
//endregion Fields

//region SECTION: Public
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array_merge(parent::registerBundles(), [new \Evrinoma\DtoBundle\EvrinomaDtoBundle(), new \Evrinoma\CodeBundle\EvrinomaCodeBundle()]);
    }

    protected function getBundleConfig(): array
    {
        return  ['framework.yaml', 'jms_serializer.yaml'];
    }

}
