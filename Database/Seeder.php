<?php

namespace Database;

interface Seeder
{
  public function seed(): void;

  public function createRowData(string $snippet, string $language, string $path, string $expiration): array;
}
