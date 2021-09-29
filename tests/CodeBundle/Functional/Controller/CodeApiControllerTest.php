<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Evrinoma\CodeBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class CodeApiControllerTest extends CaseTest implements ApiControllerTestInterface
{
//region SECTION: Fields
    private array $default = [];
//endregion Fields

//region SECTION: Protected
    protected function getDtoClass(): string
    {
        return CodeApiDto::class;
    }

    protected function getDefault(array $extend): array
    {
        return array_merge($extend, unserialize(serialize($this->default)));
    }

//endregion Protected

//region SECTION: Public
    public function testCriteria(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testCriteriaNotFound(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPut(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPutNotFound(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPutUnprocessable(): void
    {
        $this->assertTrue(true, 'message');
    }


    public function testDelete(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testDeleteNotFound(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testDeleteUnprocessable(): void
    {
        $this->assertTrue(true, 'message');
    }


    public function testGet(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testGetNotFound(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPostDuplicate(): void
    {
        $this->assertTrue(true, 'message');
    }

    public function testPostUnprocessable(): void
    {
        $this->assertTrue(true, 'message');
    }
//endregion Public
}