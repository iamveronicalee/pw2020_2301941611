<?php 
require 'functions.php';

// jika tidak ada id di url, location pindah ke header karna hapus.php perlu id (prevent error)
if(!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

// ambil id dari URL
$id = $_GET['id'];

if(hapus($id) > 0) {
  echo 
  "<script>
  alert('Data berhasil dihapus!');
  document.location.href = 'index.php';
  </script>";
} else {
  echo 
  "<script> alert('data gagal dihapus!'); </script>";
}

?>