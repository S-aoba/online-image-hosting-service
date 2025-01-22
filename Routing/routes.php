<?php

use Helpers\DatabaseHelper;
use Helpers\FileHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    '' => function(): HTTPRenderer {
      return new HTMLRenderer('component/home');
    },
    'upload' => function(): HTTPRenderer {
      return new HTMLRenderer('component/upload');
    },
    'api/image/upload' => function(): JSONRenderer {
      $file = $_FILES['image'];
      // error_log(var_export($file, true));

      /** 
       * TODO: nameをファイル名ではなく、ユーザーに保存したい名前で入力してもらい、それを使用するようにする 
       * 
      */
      $formattedFileData = FileHelper::formatFileData($file);
      // error_log(var_export($formattedFileData, true));

      /** TODO: 後ほど実装 */
      /** バリデーション */
      $validatedFileData = $formattedFileData;
      
      FileHelper::checkImageStorageDirectory();
      $imagePath = FileHelper::generateImagePath($validatedFileData['name']);
      // error_log(var_export($imagePath, true));

      $deletePath = FileHelper::generateDeletePath($validatedFileData['name']);
      // error_log(var_export($deletePath, true));

      $uniqueToken = FileHelper::generateUniqueTokenPath($validatedFileData['name']);
      // error_log(var_export($uniqueToken, true));

      $result = DatabaseHelper::saveUploadImage($formattedFileData, $imagePath, $deletePath, $uniqueToken);
      // error_log(var_export($result, true));

      if($result['success'] === false) {
        return new JSONRenderer(['message' => $result['message']]);
      }
      
      FileHelper::moveUploadFile($validatedFileData['tmp_name'], $imagePath);

      $uniqueTokenURL = "http://localhost:8000/{$validatedFileData['type']}/" . $uniqueToken;
      $deleteURL = 'http://localhost:8000/delete/' . $deletePath;

      return new JSONRenderer(['success' => $result['success'], 'message' => $result['message'], 'uniqueTokenURL' => $uniqueTokenURL, 'deleteURL' => $deleteURL]);
    }
];