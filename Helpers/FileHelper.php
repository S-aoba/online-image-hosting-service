<?php

namespace Helpers;

class FileHelper
{
  public static function hashedFileName(string $fileName): string
  {
    // hash値.拡張子
    // 画像のファイル名をハッシュ化する
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $hashedFileName = hash('sha256', $fileName) . '.' . $extension;
    return $hashedFileName;
  }

  public static function saveImageFile(string $hashed_file_name): void
  {
    $root_dir = "uploads/img/";
    $parent_dir = substr($hashed_file_name, 0, 2);

    // $parent_dirが存在しているかどうか
    if (!is_dir($root_dir . $parent_dir)) {
      mkdir($root_dir . $parent_dir, 0777, true);
    }
    $target_file = $root_dir . $parent_dir . '/' . $hashed_file_name;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
  }
}
