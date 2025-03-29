<?php
include "admin/config/koneksi.php";
error_reporting(0);

if (isset($_POST['checkout'])) {
    $tgl_bayar = date("Y-m-d");
    $tgl_bayar2 = date("d-m-Y", strtotime($tgl_bayar));
    $status_bayar = $_POST['status_bayar'];
    $status_bayar2 = ($status_bayar == "0" || $status_bayar == "1") ? "DP" : "Lunas";
    $nominal = ($status_bayar2 == "DP") ? $_POST['nominal_bayar1'] : $_POST['nominal_bayar2'];
    
    $jam_ambil = $_POST['jam_ambil'];
    $id_checkout = $_POST['id_pemesanan'];
    $tgl_ambil = date("d-m-Y", strtotime($_POST['tgl_ambil']));
    $tgl_ambil1 = $_POST['tgl_ambil'];
    $total_bayar = rupiah($nominal);
    
    // Cek data konsumen
    $cek = $koneksi->query("SELECT * FROM v_keranjang WHERE id_pemesanan='$id_checkout'");
    $row_cek = $cek->fetch_assoc();
    $data_id = $row_cek['id_konsumen'];
    
    // Upload bukti pembayaran jika ada
    $bukti = "";
    if (!empty($_FILES['bukti']['name'])) {
        $bukti = $_FILES['bukti']['name'];
        $lokasi = $_FILES['bukti']['tmp_name'];
        move_uploaded_file($lokasi, "bukti/$bukti");
    }
    
    // Simpan data pembayaran
    $query = $koneksi->query("INSERT INTO pembayaran (id_pemesanan, id_konsumen, total, bukti_pembayaran, status_bayar, tgl_bayar) 
                               VALUES ('$id_checkout', '$data_id', '$nominal', '$bukti', '$status_bayar', '$tgl_bayar')");
    
    // Update status pemesanan
    $koneksi->query("UPDATE detail_pemesanan SET status='1' WHERE id_pemesanan='$id_checkout'");
    $koneksi->query("UPDATE pemesanan SET status='1', tgl_ambil='$tgl_ambil1', jam_ambil='$jam_ambil' WHERE id_pemesanan='$id_checkout'");
    
    if ($query) {
        echo "<script>alert('Data berhasil dibayar, menunggu verifikasi kasir')</script>";
        echo "<script>location='index.php?halaman=proses'</script>";
    } else {
        echo "<script>alert('Data gagal dibayar')</script>";
        echo "<script>location='index.php?halaman=proses'</script>";
    }
}
