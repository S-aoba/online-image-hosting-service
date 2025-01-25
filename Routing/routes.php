<?php

use Helpers\DatabaseHelper;
use Helpers\FileHelper;
// use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    '' => function(): HTTPRenderer {
      return new HTMLRenderer('component/upload');
    },
    'delete' => function(): HTTPRenderer {
      $deletePath = $_GET['path'];
      // error_log(var_export($deletePath, true));

      $uploadFile = DatabaseHelper::getUploadImageByDeletePath($deletePath);
      // バリデーション？
      $result = DatabaseHelper::deleteUploadImage($deletePath);

      if($result === false) return new HTMLRenderer('component/delete-failed');
      
      // TODO: Change to using the getFullPath method of the FileHelper class to get the fullpath
      $fullUploadPath = "private/uploads/{$uploadFile['image_path']}";
      // error_log(var_export($fullUploadPath, true));

      $removeUploadFileResult = FileHelper::removeUploadFile($fullUploadPath);

      if($removeUploadFileResult === false) throw new Exception('Could not remove upload image.');
      return new HTMLRenderer('component/delete-success');
    },
    'upload/image/jpeg' => function(): HTTPRenderer {
      $imagePath = $_GET['path'];
      // error_log(var_export($imagePath, true));

      $uploadImage = DatabaseHelper::getUploadImage($imagePath);
      // error_log(var_export($uploadImage, true));
      
      // TODO: Change to using the getFullPath method of the FileHelper class to get the fullpath
      $fullUploadImagePath = '/private/uploads/' . $uploadImage['image_path'];
      // error_log(var_export($fullUploadImagePath, true));

      return new HTMLRenderer('component/upload-detail', ['imagePath' => $fullUploadImagePath]);
    },
    'upload/image/jpg' => function(): HTTPRenderer {
      $imagePath = $_GET['path'];
      // error_log(var_export($imagePath, true));

      $uploadImage = DatabaseHelper::getUploadImage($imagePath);
      // error_log(var_export($uploadImage, true));
      
      // TODO: Change to using the getFullPath method of the FileHelper class to get the fullpath
      $fullUploadImagePath = '/private/uploads/' . $uploadImage['image_path'];
      // error_log(var_export($fullUploadImagePath, true));

      return new HTMLRenderer('component/upload-detail', ['imagePath' => $fullUploadImagePath]);
    },
    'upload/image/png' => function(): HTTPRenderer {
      $imagePath = $_GET['path'];
      // error_log(var_export($imagePath, true));

      $uploadImage = DatabaseHelper::getUploadImage($imagePath);
      // error_log(var_export($uploadImage, true));
      
      // TODO: Change to using the getFullPath method of the FileHelper class to get the fullpath
      $fullUploadImagePath = '/private/uploads/' . $uploadImage['image_path'];
      // error_log(var_export($fullUploadImagePath, true));

      return new HTMLRenderer('component/upload-detail', ['imagePath' => $fullUploadImagePath]);
    },
    'upload/image/gif' => function(): HTTPRenderer {
      $imagePath = $_GET['path'];
      // error_log(var_export($imagePath, true));

      $uploadImage = DatabaseHelper::getUploadImage($imagePath);
      // error_log(var_export($uploadImage, true));
      
      // TODO: Change to using the getFullPath method of the FileHelper class to get the fullpath
      $fullUploadImagePath = '/private/uploads/' . $uploadImage['image_path'];
      // error_log(var_export($fullUploadImagePath, true));

      return new HTMLRenderer('component/upload-detail', ['imagePath' => $fullUploadImagePath]);
    },
    // API
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

      // TODO: Change to using the getFullPath method of the FileHelper class to get the fullpath
      $uniqueTokenURL = "http://localhost:8000/upload/{$validatedFileData['type']}?path=" . $uniqueToken;
      $deleteURL = 'http://localhost:8000/delete?path=' . $deletePath;
      $fullImagePath = 'private/uploads/' . $imagePath;

      return new JSONRenderer(['success' => $result['success'], 'message' => $result['message'], 'uniqueTokenURL' => $uniqueTokenURL, 'deleteURL' => $deleteURL, 'imagePath' => $fullImagePath]);
    }
];