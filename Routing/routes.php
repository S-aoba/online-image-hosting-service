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

  // Imageの作成
  // 作成したImageの表示
  // Imageの削除
];
