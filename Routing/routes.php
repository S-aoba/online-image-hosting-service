<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;

use Response\Render\JSONRenderer;

return [
  // トップページ
  "upload" => function (): HTTPRenderer {
    return new HTMLRenderer("component/upload");
  },
  "upload/post" => function (): HTTPRenderer {
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_type = $_FILES['image']['type'];
    // Userが1日にアップロードできる画像ファイルの最大サイズを超えていないかを確認する
    // 1日の最大容量5MB
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    error_log($ipAddress);
    if(!DatabaseHelper::checkDailyUploadLimitExceeded($ipAddress)) return new JSONRenderer(["status" => "1日あたりのアップロード容量を超えました。1日最大容量は、5MBです。"]);
    // アップロードされた画像のファイルの種類を確認する(対応可能拡張子: jpg, jpeg, png, gif)
    
    // アップロードされた画像のファイルサイズを確認する　一回のアップロードの最大サイズ3MBに設定
    // 画像のファイル名をハッシュ化する
    // shared_urlを生成する {https://{domain}/{media-type}/{unique-string}}
    // delete_urlを生成する
    // Userのipアドレスを取得する
    // DBのimagesテーブルに画像を保存する
    return new JSONRenderer(["status" => "Image uploaded", 'shared_url' => 'https://www.google.com', "ip_address"=> $ipAddress]);
  }
  // Imageの作成
  // 作成したImageの表示
  // Imageの削除
];
