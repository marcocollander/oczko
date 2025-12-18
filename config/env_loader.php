<?php
declare(strict_types=1);

function load_env(string $path): void
{
  if (!is_file($path)) {
    return;
  }

  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  foreach ($lines as $line) {
    $line = trim($line);

    if ($line === '' || str_starts_with($line, '#')) {
      continue;
    }

    [$name, $value] = array_map('trim', explode('=', $line, 2)) + [1 => null];

    if ($name !== '' && $value !== null) {
      $value = trim($value, "\"'");
      putenv("$name=$value");
      $_ENV[$name] = $value;
      $_SERVER[$name] = $value;
    }
  }
}

