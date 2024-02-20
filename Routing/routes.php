<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Helpers\FileHelper;
use Helpers\URLHelper;

use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;

use Response\Render\JSONRenderer;

return [
  // トップページ
  "upload" => function (): HTTPRenderer {
    return new HTMLRenderer("component/upload");
  },
  "upload/post" => function (): HTTPRenderer {
    try {
      $title = $_POST['title'];
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_type = $_FILES['image']['type'];
      // Userが1日にアップロードできる画像ファイルの最大サイズを超えていないかを確認する
      // 1日の最大容量5MB
      // ローカル環境のphp.iniのupload_max_filesizeを2MBなので、それ以上のファイルはアップロードできない。本番環境は変える必要ある。
      $ipAddress = $_SERVER['REMOTE_ADDR'];
      if (!DatabaseHelper::checkDailyUploadLimitExceeded($ipAddress)) return new JSONRenderer(["status" => "1日あたりのアップロード容量を超えました。1日最大容量は、5MBです。"]);
      // アップロードされた画像のファイルの種類を確認する(対応可能拡張子: jpg, jpeg, png, gif)
      if (!ValidationHelper::checkFileExtension($file_type)) return new JSONRenderer(["status" => "アップロードされたファイルの拡張子が対応していません。"]);
      // アップロードされた画像のファイルサイズを確認する　一回のアップロードの最大サイズ3MBに設定
      if (!DatabaseHelper::checkUploadFileSize($file_size)) return new JSONRenderer(["status" => "アップロードされたファイルのサイズが3MBを超えています。"]);
      // 画像のファイル名をハッシュ化する hash値.拡張子
      $hashed_file_name = FileHelper::hashedFileName($file_name);

      // shared_urlを生成する {https://{domain}/{media-type}/{unique-string}}
      $shared_url = URLHelper::generateSharedURL($hashed_file_name);

      // delete_urlを生成する
      $delete_url = URLHelper::generateDeleteURL($file_type);
      // DBのimagesテーブルに画像を保存する
      DatabaseHelper::saveImageFileToDB(
        $hashed_file_name,
        $shared_url,
        $delete_url,
        $ipAddress,
        $file_size,
        $title
      );
      // uploads folderに画像を保存する
      FileHelper::saveImageFile($hashed_file_name);
      return new JSONRenderer(["status" => "アップロードが完了しました。", 'shared_url' => $shared_url, "delete_url" => $delete_url]);
    } catch (Exception $e) {
      return new JSONRenderer(["status" => "画像の保存中に問題が発生しました。申し訳ありませんが、後でもう一度お試しください。"]);
    }
  },
  'shared' => function (): HTTPRenderer {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $domain = $_SERVER['HTTP_HOST'];
    $url = "https://" . $domain . $url;

    $data = DatabaseHelper::getImage($url, "shared");

    if (!$data) {
      return new HTMLRenderer("component/not-found");
    }
    $shared_path = explode('/', $url);
    if (in_array('shared', $shared_path)) {
      $extension = $shared_path[4];
      $hash = $shared_path[5];
      $parent_dir = substr($hash, 0, 2);

      return new HTMLRenderer("component/shared", ["hashed_file_name" => $hash, "file_type" => $extension, "parent_dir" => $parent_dir]);
    }
  },
  "delete" => function (): HTTPRenderer {
    // Delete Pathを取得
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $domain = $_SERVER['HTTP_HOST'];
    $url = "https://" . $domain . $url;

    $data = DatabaseHelper::getImage($url, "delete");

    if (!$data) {
      return new HTMLRenderer("component/not-found");
    }

    $parent_dir = substr($data['file_path'], 0, 2);

    $image_path = "uploads/img/" . $parent_dir . "/" . $data['file_path'];

    $delete_path_list = explode('/', $url);

    return new HTMLRenderer('component/delete', ["image_path" => $image_path, "file_type" => $delete_path_list[5], "delete_path" => $url]);
  },
  'delete/post' => function (): HTTPRenderer {
    $delete_path = $_POST['delete_path'];

    DatabaseHelper::deleteImage($delete_path);
    return new JSONRenderer(["status" => "削除しました。"]);
  }
];
