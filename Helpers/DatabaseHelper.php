<?php

namespace Helpers;

use Database\MySQLWrapper;

class DatabaseHelper
{
   public static function saveUploadImage(array $data, string $imagePath, string $deletePath, string $uniqueToken): array {
    $db = new MySQLWrapper();

    $stmt = $db->prepare("INSERT INTO images (name, image_path, delete_path, size, mime_type, unique_token) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('sssiss', $data['name'], $imagePath, $deletePath, $data['size'], $data['type'], $uniqueToken);
    $stmt->execute();

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
}