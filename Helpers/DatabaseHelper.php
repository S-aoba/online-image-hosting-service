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

  public static function checkDailyUploadLimitExceeded(string $id_address){
    $db = new MySQLWrapper();
    $stmt = $db->prepare(
    " SELECT SUM(file_size) as total_file_size
      FROM images
      WHERE ip_address = ? AND created_at > NOW() - INTERVAL 1 DAY;
    ");
    $stmt->bind_param('s', $id_address);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if($row['total_file_size'] == null) return false;
    if($row['total_file_size'] > 3 * 1024 * 1024) return false;
    if(!$row) return false;
    return $row['total_file_size'];
  }

  public static function checkUploadFileSize(string $file_size){
    if($file_size > 3 * 1024 * 1024) return false;
    return true;
  }
}
