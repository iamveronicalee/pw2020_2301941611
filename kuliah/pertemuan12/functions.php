<?php

function koneksi()
{
  return mysqli_connect('localhost', 'root', '', 'pw_2301941611');
}

function query($query)
{
  $conn = koneksi();
  $result = mysqli_query($conn, $query);

  // jika hasilnya hanya 1 data
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function tambah($data)
{
  $conn = koneksi();

  $nama = htmlspecialchars($data['nama']);
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);
  $query = "insert into mahasiswa values(null, '$nama', '$nrp', '$email', '$jurusan', '$gambar')";
  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}

function hapus($id)
{
  $conn = koneksi();
  mysqli_query($conn, "delete from mahasiswa where id = $id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  $conn = koneksi();
  $id = $data['id'];
  $nama = htmlspecialchars($data['nama']);
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);
  $query = "update mahasiswa set
              nama = '$nama',
              nrp = '$nrp',
              email = '$email',
              jurusan = '$jurusan',
              gambar = '$gambar'
            where id = $id";
  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}

function cari($keyword)
{
  $conn = koneksi();

  $query = "select * from mahasiswa
            where 
              nama like '%$keyword%' or nrp like '%$keyword%'";

  $result = mysqli_query($conn, $query);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function login($data)
{
  $conn = koneksi();

  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  // cek username
  if ($user = query("select * from user where username = '$username'")) {

    // cek password
    if(password_verify($password, $user['password'])) {

      // set session
      $_SESSION['login'] = true;
      header("Location: index.php");
      exit;
    }
  } 
  return [
    'error' => true,
    'pesan' => 'Username / Password salah!'
  ];
  
}

function registrasi($data)
{
  $conn = koneksi();

  $username = htmlspecialchars(strtolower($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // jika username / password kosong
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "<script>
      alert('username / password tidak boleh kosong!');
      document.location.href = 'registrasi.php';
    </script>";

    return false;
  }

  // jika username sudah ada
  if (query("select * from user where username = '$username'")) {
    echo "<script>
    alert('username sudah ada!');
    document.location.href = 'registrasi.php';
  </script>";

    return false;
  }

  // jika konfirmasi password tidak sesuai
  if ($password1 !== $password2) {
    echo "<script>
    alert('konfirmasi password tidak sesuai!');
    document.location.href = 'registrasi.php';
  </script>";

    return false;
  }

  // jika username & password sesuai
  //enkripsi
  $password_encrypt = password_hash($password1, PASSWORD_DEFAULT);
  // insert ke tabel user
  $query = "insert into user values('null', '$username', '$password_encrypt')";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
