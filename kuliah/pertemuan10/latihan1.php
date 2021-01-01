<?php
// koneksi ke DB & pilih Database
$conn = mysqli_connect('localhost', 'root', '', 'pw_2301941611');

// Query isi tabel mahasiswa
$result = mysqli_query($conn, "select * from mahasiswa");
// var_dump($result); -> masih dalam bentuk object

// ubah data ke dalam array
// $row = mysqli_fetch_row($result); -> array numerik
// $row = mysqli_fetch_assoc($result); -> array associative
// $row = mysqli_fetch_array($result); -> keduanya
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
}
// var_dump($rows); -> uda dalam bentuk array associative

// tampung ke variable mahasiswa
$mahasiswa = $rows;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa</title>
</head>

<body>
  <h3>Daftar Mahasiswa</h3>

  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>#</th>
      <th>Gambar</th>
      <th>NRP</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Jurusan</th>
      <th>Aksi</th>
    </tr>

    <?php $i = 1;
    foreach ($mahasiswa as $m) : ?>
      <tr>
        <td><?= $i++; ?></td>
        <td><img src="img/<?= $m['gambar']; ?>" width="100" height="100" alt=""></td>
        <td><?= $m['nrp']; ?></td>
        <td><?= $m['nama']; ?></td>
        <td><?= $m['email']; ?></td>
        <td><?= $m['jurusan']; ?></td>
        <td>
          <a href="">ubah</a> | <a href="">hapus</a>
        </td>
      </tr>
      <<?php endforeach; ?> </table> </body> </html>