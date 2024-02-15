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
}
