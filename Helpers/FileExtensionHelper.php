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

  public static function generateSharedURL(string $hashedFileName): string
  {
    $domain = $_SERVER['HTTP_HOST'];
    $parts = explode(".", $hashedFileName);
    $mediaType = end($parts);
    $url = "https://{$domain}/{$mediaType}/{$hashedFileName}";
    return $url;
  }

  public static function generateDeleteURL(string $fileType){
    // ランダムなハッシュ値を生成する
    $hashedFileName = hash('sha256', uniqid());
    $domain = $_SERVER['HTTP_HOST'];
    $url = "https://{$domain}/delete/{$fileType}/{$hashedFileName}";
    return $url;
  }
}
