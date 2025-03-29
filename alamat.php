<?php
include "admin/config/koneksi.php";
error_reporting(0);
if (isset($_POST['ubahalamat'])) {
    $data_id = $_POST['id_konsumen'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $wa = $_POST['wa'];
    $ubah = $koneksi->query("update konsumen set nama_konsumen='$nama', alamat='$alamat', no_telp='$wa' where id_konsumen='$data_id'");

    if ($ubah) {
        echo "<script>alert('Data berhasil diubah')</script>";
        echo "<script>location='index.php?halaman=keranjang'</script>";
    } else {
        echo "<script>alert('Data gagal diubah')</script>";
        echo "<script>location='index.php?halaman=keranjang'</script>";
    }
}
