const btnCari = document.querySelector('.btnCari');
const keyword = document.querySelector('.keyword');
const container = document.querySelector('.container');

// hilangkan tombol cari
btnCari.style.display = 'none';

// event ketika kita menuliskan keyword
keyword.addEventListener('keyup', function () {
  // ajax -> melakukan request terhadap halaman tanpa merefresh
  // xmlhttprequest
  const xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readystate == 4 && xhr.status == 200) {
      container.innerHTML = xhr.responseText;
    }
  };

  xhr.open('GET', 'ajax/ajax_cari.php?keyword=' + keyword.value);
  xhr.send();

  // fetch
  fetch('ajax/ajax_cari.php?keyword=' + keyword.value).then((response) => response.text()).then((response) => (container.innerHTML = response));

});

// preview image untuk tambah dan ubah
function previewImage() {
  const gambar = document.querySelector('.gambar');
  const imgPreview = document.querySelector('.imgPreview');

  const oFReader = new FileReader();
  oFReader.readAsDataURL(gambar.files[0]);

  oFReader.onload = function(oFREvent) {
    imgPreview.src = oFREvent.target.result;
  };
}