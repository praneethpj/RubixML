<?php

namespace Rubix\ML\Classifiers;

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Graph\Nodes\Decision;

/**
 * Extra Tree Classifier
 *
 * An Extremely Randomized Classification Tree that splits the training set at
 * a random point chosen among the maximum features. Extra Trees are useful in
 * Ensembles such as Random Forest or AdaBoost as the “weak” classifier or they
 * can be used on their own. The strength of Extra Trees are computational
 * efficiency as well as increasing variance of the prediction (if that is
 * desired).
 *
 * References:
 * [1] P. Geurts et al. (2005). Extremely Randomized Trees.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class ExtraTreeClassifier extends ClassificationTree
{
    /**
     * Randomized algorithm to that choses the split point with the lowest gini
     * impurity among a random selection of $maxFeatures features.
     *
     * @param \Rubix\ML\Datasets\Labeled $dataset
     * @return \Rubix\ML\Graph\Nodes\Decision
     */
    protected function findBestSplit(Labeled $dataset) : Decision
    {
        $bestGini = INF;
        $bestColumn = $bestValue = null;
        $bestGroups = [];

        $max = $dataset->numRows() - 1;

        shuffle($this->columns);

        foreach (array_slice($this->columns, 0, $this->maxFeatures) as $column) {
            $sample = $dataset[rand(0, $max)];

            $value = $sample[$column];

            $groups = $dataset->partition($column, $value);

            $gini = $this->gini($groups);

            if ($gini < $bestGini) {
                $bestColumn = $column;
                $bestValue = $value;
                $bestGroups = $groups;
                $bestGini = $gini;
            }

            if ($gini < $this->tolerance) {
                break 1;
            }
        }

        return new Decision($bestColumn, $bestValue, $bestGroups, $bestGini);
    }
}
