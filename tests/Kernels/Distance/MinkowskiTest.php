<?php

namespace Rubix\ML\Tests\Kernels\Distance;

use Rubix\ML\Kernels\Distance\Minkowski;
use Rubix\ML\Kernels\Distance\Distance;
use PHPUnit\Framework\TestCase;

class MinkowskiTest extends TestCase
{
    protected $kernel;

    protected $a;

    protected $b;

    protected $c;

    public function setUp()
    {
        $this->a = ['x' => 2, 'y' => 1, 'z' => 4];
        $this->b = ['x' => 7, 'y' => 9, 'z' => 4];
        $this->c = ['x' => 2, 'y' => 2, 'z' => 3];

        $this->kernel = new Minkowski(3.0);
    }

    public function test_build_distance_kernel()
    {
        $this->assertInstanceOf(Minkowski::class, $this->kernel);
        $this->assertInstanceOf(Distance::class, $this->kernel);
    }

    public function test_compute_distance()
    {
        $distance1 = $this->kernel->compute($this->a, $this->b);
        $distance2 = $this->kernel->compute($this->a, $this->c);
        $distance3 = $this->kernel->compute($this->b, $this->c);

        $this->assertEquals(8.604252448951648, $distance1);
        $this->assertEquals(1.2599210498948732, $distance2);
        $this->assertEquals(7.769462011672504, $distance3);
    }
}
