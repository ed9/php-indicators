<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class LoadingTest extends TestCase
{

    public function testCanSetVariablesUsingConstructor(): void
    {
        $class = new \Edward\Indicator\Loading(888, 999, false);

        $this->assertEquals(888, $class->getTotal());
        $this->assertEquals(999, $class->getBarLength());
        $this->assertEquals(false, $class->isAutoIncrement());
    }

    public function testCanSetVariablesUsingMethods(): void
    {
        $class = new \Edward\Indicator\Loading();

        $class->setCurrent(1001);
        $this->assertEquals(1001, $class->getCurrent());

        $class->setTotal(1002);
        $this->assertEquals(1002, $class->getTotal());

        $class->setBarLength(1003);
        $this->assertEquals(1003, $class->getBarLength());

        $class->setAutoIncrement(true);
        $this->assertEquals(true, $class->isAutoIncrement());

        $class->setCurrent(2001);
        $this->assertEquals(2001, $class->getCurrent());

        $class->setTotal(2002);
        $this->assertEquals(2002, $class->getTotal());

        $class->setBarLength(2003);
        $this->assertEquals(2003, $class->getBarLength());

        $class->setAutoIncrement(false);
        $this->assertEquals(false, $class->isAutoIncrement());
    }

    public function testVariablesOnCallback(): void
    {
        $class = new \Edward\Indicator\Loading(200);

        $test = $this;

        $class->ping(function ($result) use ($test) {
            $test->assertArrayHasKey('string',$result);
            $test->assertArrayHasKey('process',$result);
            $test->assertArrayHasKey('current',$result['process']);
            $test->assertArrayHasKey('total',$result['process']);
            $test->assertArrayHasKey('percentageCompleted',$result);
            $test->assertArrayHasKey('elapsed',$result);
            $test->assertArrayHasKey('value',$result['elapsed']);
            $test->assertArrayHasKey('format',$result['elapsed']);
            $test->assertArrayHasKey('eta',$result);
            $test->assertArrayHasKey('value',$result['eta']);
            $test->assertArrayHasKey('format',$result['eta']);
        });
    }

}
