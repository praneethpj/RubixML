<?php

namespace Rubix\ML\Graph\Nodes;

use Rubix\ML\Datasets\Labeled;
use InvalidArgumentException;

/**
 * Neighborhood
 *
 * Neighborhoods represent a group of samples that are close to
 * each other in distance but not necessarily the closest.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class Neighborhood extends BinaryNode implements BoundingBox, Leaf
{
    /**
     * The samples that make up the neighborhood.
     *
     * @var array
     */
    protected $samples;

    /**
     * The labels that make up the neighborhood.
     *
     * @var array
     */
    protected $labels;

    /**
     * The multivariate minimum of the bounding box around the samples
     * in the neighborhood.
     *
     * @var array
     */
    protected $min;

    /**
     * The multivariate maximum of the bounding box around the samples
     * in the neighborhood.
     *
     * @var array
     */
    protected $max;

    /**
     * Terminate a branch with a dataset.
     *
     * @param \Rubix\ML\Datasets\Labeled $dataset
     * @return self
     */
    public static function terminate(Labeled $dataset) : self
    {
        $samples = $dataset->samples();
        $labels = $dataset->labels();

        $min = $max = [];

        foreach ($dataset->columns() as $values) {
            $min[] = min($values);
            $max[] = max($values);
        }

        return new self($samples, $labels, $min, $max);
    }

    /**
     * @param array $samples
     * @param array $labels
     * @param array $min
     * @param array $max
     * @throws \InvalidArgumentException
     */
    public function __construct(array $samples, array $labels, array $min, array $max)
    {
        if (empty($samples)) {
            throw new InvalidArgumentException('Cluster cannot be empty');
        }

        if (count($samples) !== count($labels)) {
            throw new InvalidArgumentException('The number of samples'
                . ' must be equal to the number of labels.');
        }

        if (empty($min)) {
            throw new InvalidArgumentException('Bounding box cannot be empty');
        }

        if (count($min) !== count($max)) {
            throw new InvalidArgumentException('Min and max vectors must be'
                . ' the same dimensionality.');
        }

        $this->samples = $samples;
        $this->labels = $labels;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Return the bounding box surrounding this node.
     *
     * @return array[]
     */
    public function box() : array
    {
        return [$this->min, $this->max];
    }

    /**
     * Return the samples in the neighborhood.
     *
     * @return array[]
     */
    public function samples() : array
    {
        return $this->samples;
    }

    /**
     * Return the labels cooresponding to the samples in the neighborhood.
     *
     * @return (int|float|string)[]
     */
    public function labels() : array
    {
        return $this->labels;
    }
}
