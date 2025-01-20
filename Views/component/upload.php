<div class="w-full h-full flex items-center justify-center">
  <div class="max-w-screen-md w-full flex items-center justify-center h-96 shadow-md border">
  <label 
    for="file-upload" 
    class="w-1/2 h-1/2 border-8 border-dotted flex items-center justify-center hover:brightness-75 transition duration-200 ease-in-out">
      <p class="font-bold text-lg">
        Choose Photo
      </p>
  </label>
    <input type="file" id="file-upload" class="hidden">
  </div>
</div>
<script>
  const uploadButton = document.getElementById('file-upload');

  uploadButton.addEventListener('change', () => {
    console.log("ファイルがアップロードされました");
  })
</script>