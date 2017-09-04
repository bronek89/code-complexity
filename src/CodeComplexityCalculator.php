<?php declare(strict_types=1);

namespace Bronek\CodeComplexity;

use PhpParser\NodeTraverser;
use PhpParser\Parser;
use PhpParser\ParserFactory;

final class CodeComplexityCalculator implements CodeComplexity
{
    /** @var Parser */
    private $parser;

    public function __construct(Parser $parser = null)
    {
        $this->parser = $parser ?? (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
    }

    public function calculate(string $code): int
    {
        $nodeVisitor = new CalculatorNodeVisitor();

        $traverser = new NodeTraverser();
        $traverser->addVisitor($nodeVisitor);
        $traverser->traverse($this->parser->parse($code));

        return $nodeVisitor->calculatedComplexity();
    }
}
