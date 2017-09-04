<?php

namespace Bronek\CodeComplexity;

interface CodeComplexity
{
    /**
     * Calculates complexity of given code
     * Code must start with php open tag (<?php)
     */
    public function calculate(string $code): int;
}
