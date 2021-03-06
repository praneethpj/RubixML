<?php

namespace Rubix\ML\Tests\Graph;

use Rubix\ML\Graph\Tree;
use Rubix\ML\Graph\KDTree;
use Rubix\ML\Graph\BinaryTree;
use PHPUnit\Framework\TestCase;

class KDTreeTest extends TestCase
{
    protected $tree;

    public function setUp()
    {
        $this->tree = new KDTree();
    }

    public function test_build_tree()
    {
        $this->assertInstanceOf(KDTree::class, $this->tree);
        $this->assertInstanceOf(BinaryTree::class, $this->tree);
        $this->assertInstanceOf(Tree::class, $this->tree);
    }
}
