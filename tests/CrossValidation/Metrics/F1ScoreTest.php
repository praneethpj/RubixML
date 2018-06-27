<?php

namespace Rubix\Tests\CrossValidation\Metrics;

use Rubix\ML\Datasets\Labeled;
use Rubix\Tests\Helpers\MockClassifier;
use Rubix\ML\CrossValidation\Metrics\F1Score;
use Rubix\ML\CrossValidation\Metrics\Validation;
use PHPUnit\Framework\TestCase;

class F1ScoreTest extends TestCase
{
    protected $metric;
    
    protected $estimator;

    protected $testing;

    public function setUp()
    {
        $this->testing = new Labeled([[], [], [], [], []],
            ['lamb', 'lamb', 'wolf', 'wolf', 'wolf']);

        $this->estimator = new MockClassifier([
            'wolf', 'lamb', 'wolf', 'lamb', 'wolf'
        ]);

        $this->metric = new F1Score();
    }

    public function test_build_f1_score_metric()
    {
        $this->assertInstanceOf(F1Score::class, $this->metric);
        $this->assertInstanceOf(Validation::class, $this->metric);
    }

    public function test_get_range()
    {
        $this->assertEquals([0, 1], $this->metric->range());
    }

    public function test_score_predictions()
    {
        $score = $this->metric->score($this->estimator, $this->testing);

        $this->assertEquals(0.5833333404166667, $score);
    }
}
