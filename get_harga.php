<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "coba");

// mengambil parameter id_produk dari request
$id_produk = $_GET['id_produk'];

// query untuk mengambil data harga_produk
$query = "SELECT harga_produk FROM produk WHERE id_produk = '$id_produk'";
$result = mysqli_query($conn, $query);

// menampilkan data harga_produk
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    echo $row['harga_produk'];
} else {
    echo "Data tidak ditemukan";
}

mysqli_close($conn);
?>