<div class="w-full h-full flex flex-col items-center justify-center space-y-5">
  <!-- Header -->
  <div class="flex py-10 items-center">
      <p class="text-3xl font-bold font-serif text-slate-800">Online Image Hosting Service</p>
   </div>
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
  <div id="result_message"></div>
  <div id="preview" class="max-w-screen-md w-full h-96"></div>
  <div id="result_URL"></div>
</div>
<script>
  const uploadButton = document.getElementById('file-upload');

  uploadButton.addEventListener('change', async() => {
    const file = uploadButton.files[0];
    
    if(file === undefined) {
      // TODO: Indicate in the UI that file is not selected.
      console.log('ファイルが選択されていません');
      return;
    }
    
    const baseURL = 'http://localhost:8000/';
    const formData = new FormData();
    formData.append('image', file);
    const response = await fetch(baseURL + 'api/image/upload', {
      method: 'POST',
      body: formData
    })
    
    if(!response.ok) {
      // TODO: Indicate in the UI that failed upload.
      console.error('Failed upload');
      const resultMessage = document.getElementById('result_message');
      resultMessage.innerHTML = `<p>Failed upload</p>`;
    }
    
    const data = await response.json();
    if(data.success) {
      console.log(data);

      const resultMessage = document.getElementById('result_message');
      resultMessage.innerHTML = `<p>${data.message}</p>`;

      const resultURL = document.getElementById('result_URL');
      resultURL.innerHTML = `
                            <p>${data.uniqueTokenURL}</p>
                            <p>${data.deleteURL}</p>
                            `

      const preview = document.getElementById('preview');
      const img = document.createElement('img');

      img.src = data.imagePath;
      img.className = 'w-full h-full object-contain';
      preview.appendChild(img);
    }
    else {
      console.log(data.message);
      const resultMessage = document.getElementById('result_message');
      resultMessage.innerHTML = `<p>${data.message}</p>`;
    }
  })
</script>