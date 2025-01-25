<?php

namespace Helpers;

use Database\MySQLWrapper;

class DatabaseHelper
{
   public static function saveUploadImage(array $data, string $imagePath, string $deletePath, string $uniqueToken): array {
    $db = new MySQLWrapper();

    $stmt = $db->prepare("INSERT INTO images (name, image_path, delete_path, size, mime_type, unique_token) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('sssiss', $data['name'], $imagePath, $deletePath, $data['size'], $data['type'], $uniqueToken);

    if ($stmt->execute()) {
      $insertId = $db->insert_id;

      return [
          'success' => true,
          'insert_id' => $insertId,
          'message' => 'Image saved successfully.'
      ];
    } else {
      return [
          'success' => false,
          'message' => 'Failed to save image: ' . $stmt->error
      ];
    }
  }

  public static function getUploadImage(string $imagePath) : array {
    $db = new MySQLWrapper();

    $stmt = $db->prepare("SELECT * FROM images WHERE unique_token = ?");
    $stmt->bind_param('s', $imagePath);
    $stmt->execute();

    $result = $stmt->get_result();
    $image = $result->fetch_assoc();

    return $image;
  }

  public static function deleteUploadImage(string $deletePath): bool {
    $db = new MySQLWrapper();

    $stmt = $db->prepare("DELETE FROM images WHERE delete_path = ?");
    $stmt->bind_param('s', $deletePath);
    $stmt->execute();

    $affectRows = $stmt->affected_rows;
    
    return $affectRows > 0;
  }
}