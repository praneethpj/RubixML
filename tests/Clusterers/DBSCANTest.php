<?php

namespace Rubix\ML\Tests\Clusterers;

use Rubix\ML\Estimator;
use Rubix\ML\Clusterers\DBSCAN;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Other\Helpers\DataType;
use Rubix\ML\Datasets\Generators\Blob;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\Datasets\Generators\Agglomerate;
use Rubix\ML\CrossValidation\Metrics\VMeasure;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class DBSCANTest extends TestCase
{
    protected const TEST_SIZE = 300;
    protected const MIN_SCORE = 0.9;

    protected $generator;

    protected $estimator;

    protected $metric;

    public function setUp()
    {
        $this->generator = new Agglomerate([
            'red' => new Blob([255, 0, 0], 3.),
            'green' => new Blob([0, 128, 0], 1.),
            'blue' => new Blob([0, 0, 255], 2.),
        ], [3, 3, 4]);

        $this->estimator = new DBSCAN(10.0, 75, new Euclidean(), 20);

        $this->metric = new VMeasure();
    }

    public function test_build_clusterer()
    {
        $this->assertInstanceOf(DBSCAN::class, $this->estimator);
        $this->assertInstanceOf(Estimator::class, $this->estimator);

        $this->assertEquals(Estimator::CLUSTERER, $this->estimator->type());

        $this->assertNotContains(DataType::CATEGORICAL, $this->estimator->compatibility());
        $this->assertContains(DataType::CONTINUOUS, $this->estimator->compatibility());
    }

    public function test_predict()
    {
        $testing = $this->generator->generate(self::TEST_SIZE);

        $predictions = $this->estimator->predict($testing);

        $score = $this->metric->score($predictions, $testing->labels());

        $this->assertGreaterThanOrEqual(self::MIN_SCORE, $score);
    }

    public function test_predict_incompatible()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->estimator->predict(Unlabeled::quick([['bad']]));
    }
}
