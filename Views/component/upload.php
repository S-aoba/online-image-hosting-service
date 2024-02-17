<!-- Userが画像をアップロードする際に表示するコンポーネント -->

<div class="w-screen h-full flex justify-center pt-10">
  <div class="flex flex-col items-center w-11/12 h-fit flex justify-center pt-10">
    <div class="w-1/2 h-full grid grid-cols-2 py-2">
      <h2 class="col-span-1 text-xl font-bold">プレビュー</h2>
      <h2 class="col-span-1 text-xl font-bold pl-5">設定</h2>
    </div>
    <div class="w-1/2 h-full grid grid-cols-2">
      <div class="col-span-1 border border-gray-500 border-dashed bg-white">
        <?php
        $str = file_get_contents('uploads/img/test.png');
        printf('<img src="data:image/png;base64,%s" class="object-cover max-h-full">', base64_encode($str));
        ?>
      </div>
      <div class="col-span-1 pt-10 pl-5">
        <div class="flex flex-col space-y-5">
          <input type="text" placeholder="タイトル" class="p-2">
          <input type="file">
          <div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">投稿する</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
