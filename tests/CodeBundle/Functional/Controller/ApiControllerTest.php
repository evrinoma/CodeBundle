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
class ApiControllerTest extends CaseTest implements ApiControllerTestInterface
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
      //  $this->assertCount(1, 1);
    }

    public function testCriteriaNotFound(): void
    {
        $this->assertCount(1, 1);
    }

    public function testPut(): void
    {
        $this->assertCount(1, 1);
    }

    public function testPutNotFound(): void
    {
        $this->assertCount(1, 1);
    }

    public function testPutUnprocessable(): void
    {
        $this->assertCount(1, 1);
    }


    public function testDelete(): void
    {
        $this->assertCount(1, 1);
    }

    public function testDeleteNotFound(): void
    {
        $this->assertCount(1, 1);
    }

    public function testDeleteUnprocessable(): void
    {
        $this->assertCount(1, 1);
    }


    public function testGet(): void
    {
        $this->assertCount(1, 1);
    }

    public function testGetNotFound(): void
    {
        $this->assertCount(1, 1);
    }

    public function testPostDuplicate(): void
    {
        $$this->assertCount(1, 1);
    }

    public function testPostUnprocessable(): void
    {
        $this->assertCount(1, 1);
    }
//endregion Public
}