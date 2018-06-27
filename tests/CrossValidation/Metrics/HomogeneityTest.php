<?php

namespace Rubix\Tests\CrossValidation\Metrics;

use Rubix\ML\Datasets\Labeled;
use Rubix\Tests\Helpers\MockClusterer;
use Rubix\ML\CrossValidation\Metrics\Validation;
use Rubix\ML\CrossValidation\Metrics\Homogeneity;
use PHPUnit\Framework\TestCase;

class HomogeneityTest extends TestCase
{
    protected $metric;

    protected $estimator;

    protected $testing;

    public function setUp()
    {
        $this->testing = new Labeled([[], [], [], [], []],
            ['lamb', 'lamb', 'wolf', 'wolf', 'wolf']);

        $this->estimator = new MockClusterer([1, 2, 2, 1, 2]);

        $this->metric = new Homogeneity();
    }

    public function test_build_homogeneity_metric()
    {
        $this->assertInstanceOf(Homogeneity::class, $this->metric);
        $this->assertInstanceOf(Validation::class, $this->metric);
    }

    public function test_get_range()
    {
        $this->assertEquals([0, 1], $this->metric->range());
    }

    public function test_score_predictions()
    {
        $score = $this->metric->score($this->estimator, $this->testing);

        $this->assertEquals(0.5833333280555556, $score);
    }
}
