<?php

namespace Helpers;

use Exception;

class FileHelper {
  public static function formatFileData(array $file): array {
    $formatList = ['name', 'type', 'size', 'tmp_name'];
    $formattedFile = [];

    foreach($file as $key => $val) {
      if(in_array($key, $formatList)) {
        if($key === 'name') {
          // nameを50文字に切り取る。ユーザーが入力する形に変更したら削除する
          $newVal = mb_substr($file['name'], 0, 49, 'UTF-8');
          $formattedFile[$key] = $newVal;
          continue;
        }
        $formattedFile[$key] = $val;
      }
    }
    
    return $formattedFile;
  }

  public static function generateImagePath(string $filename): string {
    $dateStr = date('Ymd');
    $uniqueStr = uniqid();

    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return $dateStr . '_' . $uniqueStr . '.' . $ext;
  }

  public static function checkImageStorageDirectory(): void {
    $privatDir = 'private';
    if(is_dir($privatDir) === false) {
      mkdir($privatDir);
    }

    $imgDir = 'private/uploads';
    if(is_dir($imgDir) === false) {
      mkdir($imgDir);
    }

    return;
  }

  public static function generateDeletePath(string $filename): string {
    $salt = 'delete_at';
    return hash_hmac('sha256', $filename, $salt);
  }

  public static function generateUniqueTokenPath(string $filename): string {
    return hash('sha256', $filename);
  }

  public static function moveUploadFile(string $tempFilePath, string $imagePath): void {
    $savePath = 'private/uploads/' . $imagePath;
    
    $result = move_uploaded_file($tempFilePath, $savePath);
    if($result === false) throw new Exception('Could not move upload file.');
  }
}