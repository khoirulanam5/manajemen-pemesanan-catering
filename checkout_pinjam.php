<?php
include "admin/config/koneksi.php";
error_reporting(0);
if (isset($_POST['checkoutpinjam'])) {
    $data_id = $_POST['id_konsumen'];
    $total_harga = $_POST['total_harga'];
    $status_bayar = $_POST['status_bayar'];
    $status_bayar2 = $_POST['status_bayar'];
    $tgl_bayar = date("Y-m-d");
    $tgl_bayar2 = date("d-m-Y");
    if ($status_bayar2 == '0') {
        $status_bayar2 = "DP";
        $nominal = $_POST['nominal_bayar1'];
    } else {
        $status_bayar2 = "Lunas";
        $nominal = $_POST['nominal_bayar2'];
    }
    $id_checkout = $_POST['id_peminjaman'];
    $tgl_ambil = date("d-m-Y", strtotime($_POST['tgl_ambil']));
    $tgl_ambil1 = $_POST['tgl_ambil'];
    $total_bayar = rupiah($nominal);
    // cek wa
    $cek = $koneksi->query("SELECT sum(total_bayar) as total_bayar, no_telp, tgl_pinjam FROM v_pinjam where id_peminjaman='$id_checkout'");
    $row_cek = $cek->fetch_assoc();
    $no_wa_konsumen = $row_cek['no_telp'];
    $total_harga3 = $row_cek['total_bayar'];
    $total_harga2 = rupiah($total_harga3);
    $tgl_pinjam = date("d-m-Y", strtotime($row_cek['tgl_pinjam']));
    $bukti = $_FILES['bukti']['name'];
    $lokasi = $_FILES['bukti']['tmp_name'];
    // $no_wa_konsumen = "6287897315639";
    move_uploaded_file($lokasi, "bukti/$bukti");
    // cek 2
    $cek2 = $koneksi->query("SELECT * FROM vv_barang where id_peminjaman='$id_checkout'");
    $row_cek2 = $cek2->fetch_assoc();
    $namaproduk = $row_cek2['nama_barang'];
    $hargaproduk = $row_cek2['harga_awal'];
    $total_hari = $row_cek2['total_hari_awal'];
    $harga = rupiah($hargaproduk);
    $qtyproduk = $row_cek2['quantity_awal'];
    $ubah = $koneksi->query("insert into pembayaran_pinjam (id_peminjaman,id_konsumen,total,bukti_pembayaran,status_bayar,tgl_bayar) values ('$id_checkout','$data_id','$nominal','$bukti','$status_bayar','$tgl_bayar')");
    $ubah = $koneksi->query("update detail_peminjaman set status='1' where id_peminjaman='$id_checkout'");
    $ubah = $koneksi->query("update peminjaman set status='1', tgl_ambil='$tgl_ambil1', total='$total_harga' where id_peminjaman='$id_checkout'");
    if ($ubah) {
        echo "<script>alert('Data berhasil dibayar, menunggu verifikasi kasir')</script>";
        echo "<script>location='index.php?halaman=proses'</script>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Invoice Baru*\n\nID pesan : $id_checkout\nTgl Bayar : $tgl_bayar2\nTgl Pinjam : $tgl_pinjam\nTgl Ambil : $tgl_ambil\nProduk : $namaproduk\nHarga : $hargaproduk\nTotal hari : $total_hari\nQty : $qtyproduk\nTotal Bayar : *$total_harga2*\nBayar : *$status_bayar2*\nStatus : *Pembayaran anda sedang dicek kasir*\nNominal Bayar : *{$total_bayar}*\n\nRegards,Lina Catering ~ Kudus";
        $data = [
            'phone' => $no_wa_konsumen,
            'message' => $pesan,
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://kudus.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    } else {
        echo "<script>alert('Data gagal dibayar')</script>";
        echo "<script>location='index.php?halaman=proses'</script>";
    }
}
