<?php declare(strict_types=1);

function foobar($vectors = array(STDIN)) {
  $foo = "foo";
  $bar = "bar";

  for ($index = 0; $index <= sizeof($vectors); $index++) {
    if ($index % 3 == 0) printf($foo);
    if ($index % 5 == 0) printf($bar);
    if ($index % 3 != 0 || $index % 5 != 0) printf($foo.$bar);
  }
}
