<!-- Userが画像をアップロードする際に表示するコンポーネント -->

<div class="w-screen h-full flex justify-center pt-10">
  <div class="flex flex-col items-center w-11/12 h-fit flex justify-center pt-10">
    <div class="w-1/2 h-full grid grid-cols-2 py-2">
      <h2 class="col-span-1 text-xl font-bold">プレビュー</h2>
      <h2 class="col-span-1 text-xl font-bold pl-5">設定</h2>
    </div>
    <div class="w-1/2 h-full grid grid-cols-2">
      <!-- Preview -->
      <!-- TODO アップロードされた画像に対して縦横比を変える。ただし、最大値は設定しておく -->
      <div class="min-h-96 col-span-1 border border-gray-500 border-dashed bg-white">
        <img id="preview-image" src="" class="object-cover max-h-full">
      </div>
      <!-- Setting -->
      <div class="col-span-1 pt-10 pl-5">
        <div id="upload-form" action="/upload/post" method="post" class="flex flex-col space-y-5" enctype="multipart/form-data">
          <input id="title" name="title" type="text" placeholder="タイトル" class="p-2" required>
          <input id="image" name="image" type="file" accept=".png, .jpg, .jpeg, .gif" required>
          <div>
            <button id="upload-button" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">投稿する</button>
          </div>
          <div id="result" class="w-full h-fit bg-white">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('image').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview-image').setAttribute('src', e.target.result);
      }
      reader.readAsDataURL(file);
    }
    // console.log(file);
    const title = document.getElementById('title');
    const form = new FormData();

    form.append('title', title.value);
    form.append('image', file);

    document.getElementById('upload-button').addEventListener('click', function() {
      fetch('/upload/post', {
        method: 'POST',
        body: form
      }).then(function(response) {
        // console.log(response);
        return response.json();
      }).then(function(data) {
        // data={status: "Image uploaded"}
        // console.log(data);
        // エラーの場合の処理
        if (data.status == "アップロードが完了しました。") {
          document.getElementById('result').innerHTML =
            `
          <div class="py-5 px-3">
            <div id="upload-status">${data.status}</div>
            <div class="mt-3 flex flex-col space-y-5 word-break">
              <div>
                <p>共有用URLはこちら↓</p>
                <a href="${data.shared_url}" class="break-all underline underline-offset-4 hover:underline hover:text-blue-500 hover:cursor-pointer">${data.shared_url}</a>
              </div>
              <div>
                <p>削除用URLはこちら↓</p>
                <a href="${data.delete_url}" class="break-all underline underline-offset-4 hover:underline hover:text-blue-500 hover:cursor-pointer">${data.delete_url}</a>
              </div>
            </div>
          </div>
        `;
        } else {
          document.getElementById('result').innerHTML =
            `
            <div id="upload-status" class="py-5 px-3">${data.status}</div>
          `;
        }
      })
    });
  });
</script>
