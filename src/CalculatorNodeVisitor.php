<?php declare(strict_types=1);

namespace Bronek\CodeComplexity;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

final class CalculatorNodeVisitor extends NodeVisitorAbstract
{
    private $complexity = 0;

    private const STMTS = [
        Node\Stmt\If_::class,
        Node\Stmt\Case_::class,
        Node\Stmt\Function_::class,
        Node\Stmt\ClassMethod::class,
        Node\Stmt\Catch_::class,
        Node\Stmt\For_::class,
        Node\Stmt\Foreach_::class,
        Node\Stmt\While_::class,
        Node\Stmt\ElseIf_::class,
        Node\Expr\BinaryOp\LogicalXor::class,
        Node\Expr\BinaryOp\BooleanAnd::class,
        Node\Expr\BinaryOp\BooleanOr::class,
    ];

    public function enterNode(Node $node): void
    {
        if (in_array(get_class($node), self::STMTS, true)) {
            ++$this->complexity;
        }
    }

    public function calculatedComplexity(): int
    {
        return $this->complexity;
    }
}
