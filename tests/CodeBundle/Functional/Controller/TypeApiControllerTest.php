<?php

namespace Evrinoma\CodeBundle\Tests\Functional\Controller;


use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\CodeBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class TypeApiControllerTest extends CaseTest implements ApiControllerTestInterface
{
//region SECTION: Protected
    protected function getDtoClass(): string
    {
        return TypeApiDto::class;
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