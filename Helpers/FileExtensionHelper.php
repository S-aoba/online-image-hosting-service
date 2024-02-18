<?php

namespace Helpers;

class FileExtensionHelper
{
  public static function hashedFileName(string $fileName): string
  {
    // hash値.拡張子
    // 画像のファイル名をハッシュ化する
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $hashedFileName = hash('sha256', $fileName) . '.' . $extension;
    return $hashedFileName;
  }

 
}
