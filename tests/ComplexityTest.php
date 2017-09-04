<?php declare(strict_types=1);

namespace tests\Bronek\CodeComplexity;

use Bronek\CodeComplexity\CodeComplexityCalculator;
use PHPUnit\Framework\TestCase;

final class ComplexityTest extends TestCase
{
    private static function assertCodeComplexity(int $complexity, string $code): void
    {
        $calculator = new CodeComplexityCalculator();

        self::assertEquals($complexity, $calculator->calculate($code), 'Complexity of code');
    }

    /** @test */
    function calculating_code_complexity()
    {
        self::assertCodeComplexity(
            0,
            <<<EOT
            <?php
            class x {}
EOT
        );

        self::assertCodeComplexity(
            1,
            <<<EOT
            <?php
            class x {
                function text() {}
            }
EOT
        );

        self::assertCodeComplexity(
            8,
            <<<EOT
            <?php
class CyclomaticComplexityNumber                        
{                                                       
    public function example( \$x, \$y )                   
    {                                                   
        if ( \$x > 23 || \$y < 42 )                       
        {                                               
            for ( \$i = \$x; \$i >= \$x && \$i <= \$y; ++\$i ) 
            {                                           
            }                                           
        }                                               
        else                                            
        {                                               
            switch ( \$x + \$y )                          
            {                                           
                case 1:                                 
                    break;                              
                case 2:                                 
                    break;                              
                default:                                
                    break;                              
            }                                           
        }                                               
    }                                                   
}                                                       
EOT
        );

        self::assertCodeComplexity(
            16,
            <<<EOT
            <?php
// ...
function _countCalls(PHP_Depend_Code_AbstractCallable \$callable)
{
    \$callT  = array(
        \PDepend\Source\Tokenizer\Tokens::T_STRING,
        \PDepend\Source\Tokenizer\Tokens::T_VARIABLE
    );
    \$chainT = array(
        \PDepend\Source\Tokenizer\Tokens::T_DOUBLE_COLON,
        \PDepend\Source\Tokenizer\Tokens::T_OBJECT_OPERATOR,
    );

    \$called = array();

    \$tokens = \$callable->getTokens();
    \$count  = count(\$tokens);
    for (\$i = 0; \$i < \$count; ++\$i) {
        // break on function body open
        if (\$tokens[\$i]->type === \PDepend\Source\Tokenizer\Tokens::T_CURLY_BRACE_OPEN) {
            break;
        }
    }

    for (; \$i < \$count; ++\$i) {
        // Skip non parenthesis tokens
        if (\$tokens[\$i]->type !== \PDepend\Source\Tokenizer\Tokens::T_PARENTHESIS_OPEN) {
            continue;
        }
        // Skip first token
        if (!isset(\$tokens[\$i - 1]) || !in_array(\$tokens[\$i - 1]->type, \$callT)) {
            continue;
        }
        // Count if no other token exists
        if (!isset(\$tokens[\$i - 2]) && !isset(\$called[\$tokens[\$i - 1]->image])) {
            \$called[\$tokens[\$i - 1]->image] = true;
            ++\$this->_calls;
            continue;
        } else if (in_array(\$tokens[\$i - 2]->type, \$chainT)) {
            \$identifier = \$tokens[\$i - 2]->image . \$tokens[\$i - 1]->image;
            for (\$j = \$i - 3; \$j >= 0; --\$j) {
                if (!in_array(\$tokens[\$j]->type, \$callT)
                    && !in_array(\$tokens[\$j]->type, \$chainT)
                ) {
                    break;
                }
                \$identifier = \$tokens[\$j]->image . \$identifier;
            }

            if (!isset(\$called[\$identifier])) {
                \$called[\$identifier] = true;
                ++\$this->_calls;
            }
        } else if (\$tokens[\$i - 2]->type !== \PDepend\Source\Tokenizer\Tokens::T_NEW
            && !isset(\$called[\$tokens[\$i - 1]->image])
        ) {
            \$called[\$tokens[\$i - 1]->image] = true;
            ++\$this->_calls;
        }
    }
}
EOT
        );
    }
}
