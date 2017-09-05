# code-complexity

Class for check code complexity score of php code.

## Install

```
composer require bronek89/code-complexity
```

## Usage

```php
<?php

$calculator = new \Bronek\CodeComplexity\CodeComplexityCalculator();
$complexityScore = $calculator->calculate(file_get_contents('file.php'));

echo "Code Complexity of file file.php is $complexityScore" 
```
