<?php declare(strict_types=1);

function foobar()
{
  $foo = "foo";
  $bar = "bar";
  $newlines = "\n";

  for ($index = 0; $index <= 100; $index++) {
    if ($index % 3 == 0)
      printf($foo . $newlines);
    else if ($index % 5 == 0)
      printf($bar . $newlines);
    else
      printf($foo . $bar . $newlines);
  }
}

function main()
{
  foobar();
  return 0;
}

main();
