<?php
// 画像ファイルのデータをbase64でエンコードする
$image_data = base64_encode(file_get_contents($image_path));

// data URI スキームの生成
$data_uri = "data:image/$file_type;base64,$image_data";
?>

<div class="flex flex-col w-full h-full my-3 p-3 items-center">
  <div class="flex items-center space-x-5 py-10">
    <p class="text-2xl font-bold">削除ページ</p>
    <div>
      <button id="delete" type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        削除する
      </button>
    </div>
    <div id="delete_status" class="text-red-500 ml-5"></div>
  </div>
  <div class="w-fit h-fit max-h-[600px] flex justify-center bg-white">
    <img id="image" src="<?= $data_uri ?>" class="object-cover max-h-full" />
  </div>
</div>


<script>
  const deleteBtn = document.getElementById("delete");
  const form = new FormData();

  form.append("delete_path", "<?= $delete_path ?>");

  deleteBtn.addEventListener("click", () => {
    if (!confirm("本当に削除しますか?")) return;
    fetch('/delete/post', {
      method: 'POST',
      body: form
    }).then((response) => {
      console.log(response);
      return response.json();
    }).then((data) => {
      console.log(data.status);
      document.getElementById("delete_status").innerHTML = data.status;
      deleteBtn.disabled = true;
      deleteBtn.className += " cursor-not-allowed opacity-50";
    })
  });
</script>
