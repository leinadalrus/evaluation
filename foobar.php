<?php declare(strict_types=1);

function foobar() {
  $foo = "foo";
  $bar = "bar";

  $a_hundred = 100;
  $newlines = "\n";

  for ($index = 0; $index <= sizeof($a_hundred); $index++) {
    if ($index % 3 == 0) printf($foo.$newlines);
    else if ($index % 5 == 0) printf($bar.$newlines);
    else ($index % 3 != 0 || $index % 5 != 0) printf($foo.$bar.$newlines);
  }
}

function main() 
{
  foobar();
  return 0;
}

main();
