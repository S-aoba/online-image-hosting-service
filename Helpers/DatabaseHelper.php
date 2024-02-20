<?php

namespace Helpers;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
  public static function saveSnippet(string $snippet, string $language, string $hashedValue, string $expiration,)
  {
    $db = new MySQLWrapper();
    $stmt = $db->prepare("INSERT INTO snippets(snippet, language, path, expiration) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $snippet, $language, $hashedValue, $expiration);
    $result = $stmt->execute();

    if (!$result) throw new Exception("Error executing INSERT query: " . $stmt->error);

    return true;
  }

  public static function getSnippet(string $hashedValue)
  {
    $db = new MySQLWrapper();
    $stmt = $db->prepare("SELECT * FROM snippets WHERE path = ?");
    $stmt->bind_param('s', $hashedValue);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row;
  }

  public static function deleteSnippet(string $hashedValue)
  {
    $db = new MySQLWrapper();
    $stmt = $db->prepare("DELETE FROM snippets WHERE path = ?");
    $stmt->bind_param('s', $hashedValue);
    $stmt->execute();
  }

  public static function checkDailyUploadLimitExceeded(string $id_address)
  {
    $db = new MySQLWrapper();
    $stmt = $db->prepare(
      " SELECT SUM(file_size) as total_file_size
      FROM images
      WHERE ip_address = ? AND created_at > NOW() - INTERVAL 1 DAY;
    "
    );
    $stmt->bind_param('s', $id_address);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['total_file_size'] > 5 * 1024 * 1024) return false;
    if (!$row) return false;
    return true;
  }

  public static function checkUploadFileSize(string $file_size)
  {
    if ($file_size > 3 * 1024 * 1024) return false;
    return true;
  }

  public static function saveImageFileToDB(string $file_path, string $shared_path, string $delete_path, string $ip_address, string $file_size, string $title)
  {
    $db = new MySQLWrapper();
    $stmt = $db->prepare("INSERT INTO images(file_path, shared_path, delete_path , ip_address, file_size, title) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssss', $file_path, $shared_path, $delete_path, $ip_address, $file_size, $title);
    $result = $stmt->execute();
    if (!$result) throw new Exception("Error executing INSERT query: " . $stmt->error);
  }

  public static function getImage(string $path, string $type)
  {
    $db = new MySQLWrapper();

    if ($type === "shared") {
      // DBから画像を取得する
      $stmt = $db->prepare("SELECT * FROM images WHERE shared_path = ?");
      $stmt->bind_param('s', $path);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

      if (!$row) return false;
      return $row;
    } else if ($type === "delete") {
      // DBから画像を取得する
      $stmt = $db->prepare("SELECT * FROM images WHERE delete_path = ?");
      $stmt->bind_param('s', $path);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      if (!$row) return false;
      return $row;
    }
  }

  public static function deleteImage(string $path = "")
  {
    try {
      $db = new MySQLWrapper();
      $stmt = $db->prepare("DELETE FROM images WHERE delete_path = ?");
      $stmt->bind_param('s', $path);
      $stmt->execute();
    } catch (Exception $e) {
      throw new Exception("Error executing DELETE query: " . $stmt->error);
    }
  }

  public static function increaseViewCount(string $path)
  {
    $db = new MySQLWrapper();
    $stmt = $db->prepare("UPDATE images SET view_count = view_count + 1 WHERE shared_path = ?");
    $stmt->bind_param('s', $path);
    $stmt->execute();
  }
}
