<?php

namespace Rubix\ML\Transformers;

use Closure;

/**
 * Lambda Function
 *
 * Run a stateless lambda function (*anonymous* function) over the sample
 * matrix. The lambda function receives the sample matrix as an argument and
 * should return the transformed sample matrix.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class LambdaFunction implements Transformer
{
    /**
     * The user specified lambda function.
     *
     * @var Closure
     */
    protected $lambda;

    /**
     * @param Closure $lambda
     */
    public function __construct(Closure $lambda)
    {
        $this->lambda = $lambda;
    }

    /**
     * Transform the dataset in place.
     *
     * @param array $samples
     */
    public function transform(array &$samples) : void
    {
        $samples = call_user_func($this->lambda, $samples);
    }
}
