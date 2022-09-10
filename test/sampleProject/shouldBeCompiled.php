<?php

/* Initialize some variables using C style comments
   $a - contains a-coefficient
   $b - contains b-coefficient
   $x - value we are evaluating
   $y - result from evaluating equation
*/
$a = 1;
$b = 2;
$x = 1;
$y = $a * $x + $b;
if ($y < 5)                // C++ style comment, check if y<5
{
    # Shell style comment, display something when y<5
    echo "Guess what?  y is less than 5!";
}

