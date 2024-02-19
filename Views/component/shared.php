<?php
// 画像ファイルのパス
$image_path = "uploads/img/" . $parent_dir . "/" . $hashed_file_name . "." . $file_type;

// 画像ファイルのデータをbase64でエンコードする
$image_data = base64_encode(file_get_contents($image_path));

// data URI スキームの生成
$data_uri = "data:image/$file_type;base64,$image_data";
?>

<div class="flex flex-col w-full h-full my-3 p-3 items-center">
  <div class="flex items-center space-x-5 py-10">
    <p class="text-2xl font-bold">閲覧回数: 1</p>
    <div>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <a href="http://localhost:8000/upload">投稿ページへ</a>
      </button>
    </div>
  </div>
  <div class="w-fit h-fit max-h-[600px] flex justify-center bg-white">
    <img src="<?= $data_uri ?>" class="object-cover max-h-full" />
  </div>
</div>
