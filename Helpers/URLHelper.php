<?php

namespace Helpers;


class URLHelper
{
  public static function generateSharedURL(string $hashedFileName): string
  {
    $domain = $_SERVER['HTTP_HOST'];
    $parts = explode(".", $hashedFileName);
    $mediaType = end($parts);
    $url = "https://{$domain}/shared/{$mediaType}/{$hashedFileName}";
    return $url;
  }

  public static function generateDeleteURL(string $fileType)
  {
    // ランダムなハッシュ値を生成する
    $hashedFileName = hash('sha256', uniqid());
    $domain = $_SERVER['HTTP_HOST'];
    $url = "https://{$domain}/delete/{$fileType}/{$hashedFileName}";
    return $url;
  }
}
