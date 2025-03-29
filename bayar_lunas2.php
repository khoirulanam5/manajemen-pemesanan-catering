<?php
include "admin/config/koneksi.php";
error_reporting(0);

if (isset($_POST['bayar_lunas'])) {
    $status_bayar = $_POST['status_bayar'];
    $tgl_bayar = date("Y-m-d");
    $data_id = $_POST['id_konsumen'];
    $id_checkout = $_POST['id_pemesanan'];
    $nominal = $_POST['nominal_bayar'];
    $tgl_ambil = date("Y-m-d", strtotime($_POST['tgl_ambil']));
    $jam_ambil = $_POST['jam_ambil'];
    
    // Cek data pesanan
    $cek_pesanan = $koneksi->query("SELECT * FROM v_keranjang WHERE id_pemesanan='$id_checkout'");
    $row_pesanan = $cek_pesanan->fetch_assoc();

    // Ambil nomor telepon konsumen
    $no_wa_konsumen = $row_pesanan['no_telp'];
    $tgl_pesan = date("Y-m-d", strtotime($row_pesanan['tgl_pesan']));

    // Upload bukti pembayaran
    $bukti = $_FILES['bukti']['name'];
    $lokasi = $_FILES['bukti']['tmp_name'];
    move_uploaded_file($lokasi, "bukti/$bukti");

    // Cek total harga dari semua produk dalam pesanan
    $cek_produk = $koneksi->query("SELECT SUM(harga_awal * quantity_awal) AS total_harga FROM vv_produk WHERE id_pemesanan='$id_checkout'");
    $row_produk = $cek_produk->fetch_assoc();
    $total_harga = $row_produk['total_harga'];

    // Simpan pembayaran
    $simpan_pembayaran = $koneksi->query("INSERT INTO pembayaran (id_pemesanan, id_konsumen, total, bukti_pembayaran, status_bayar, tgl_bayar) VALUES ('$id_checkout', '$data_id', '$nominal', '$bukti', '2', '$tgl_bayar')");

    // Update status detail pemesanan & pemesanan
    $update_detail = $koneksi->query("UPDATE detail_pemesanan SET status='1' WHERE id_pemesanan='$id_checkout'");
    $update_pemesanan = $koneksi->query("UPDATE pemesanan SET status='1' WHERE id_pemesanan='$id_checkout'");

    // Cek apakah semua query berhasil dijalankan
    if ($simpan_pembayaran && $update_detail && $update_pemesanan) {
        echo "<script>alert('Data berhasil dibayar, menunggu verifikasi kasir')</script>";
        echo "<script>location='index.php?halaman=proses'</script>";
    } else {
        echo "<script>alert('Data gagal dibayar')</script>";
        echo "<script>location='index.php?halaman=proses'</script>";
    }
}
?>
