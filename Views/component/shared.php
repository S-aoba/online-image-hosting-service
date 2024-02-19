<?php
// 画像ファイルのパス
$image_path = "uploads/img/" . $parent_dir . "/" . $hashed_file_name . "." . $file_type;

// 画像ファイルのデータをbase64でエンコードする
$image_data = base64_encode(file_get_contents($image_path));

// data URI スキームの生成
$data_uri = "data:image/$file_type;base64,$image_data";
?>

<div class="w-full h-full my-3 p-3 flex justify-center">
  <div class="w-5/12 h-fit bg-white">
    <img src="<?= $data_uri ?>" />
  </div>
  <div>
    <button>
      <a href="http://localhost:8000/upload">投稿ページへ</a>
    </button>
  </div>
</div>
