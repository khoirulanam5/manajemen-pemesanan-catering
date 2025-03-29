<?php
include "config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .hr {
            border: 3px #EDCB3C solid;
        }
    </style>
</head>

<body>
    <div class="row" style="margin: 0px;">
        <div class="col-2">
            <center>
                <img src="../img/DM.png" alt="" width="100%" style="margin: 0px;">
            </center>
        </div>
        <div class="col-10">
            <h4 style="margin: 0px;">
                <center>Sistem Informasi Manajemen Catering</center>
            </h4>
            <center class="my-2">
                Desa Kedungsari, Kec. Gebog, Kabupaten Kudus, Jawa Tengah
            </center>
        </div>
    </div>
    <div class="border-top my-3 hr"></div>
    <?php
    if (isset($_POST['cetak'])) {
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];
        if ($bulan == "01") {
            $bulan2 = "JANUARI";
        } elseif ($bulan == "02") {
            $bulan2 = "FEBRUARI";
        } elseif ($bulan == "03") {
            $bulan2 = "MARET";
        } elseif ($bulan == "04") {
            $bulan2 = "APRIL";
        } elseif ($bulan == "05") {
            $bulan2 = "MEI";
        } elseif ($bulan == "06") {
            $bulan2 = "JUNI";
        } elseif ($bulan == "07") {
            $bulan2 = "JULI";
        } elseif ($bulan == "08") {
            $bulan2 = "AGUSTUS";
        } elseif ($bulan == "09") {
            $bulan2 = "SEPTEMBER";
        } elseif ($bulan == "10") {
            $bulan2 = "OKTOBER";
        } elseif ($bulan == "11") {
            $bulan2 = "NOVEMBER";
        } elseif ($bulan == "12") {
            $bulan2 = "DESEMBER";
        }
    ?>
        <center>
            <h5><strong>LAPORAN PEMESANAN BULAN <?= $bulan2 ?> <?= $tahun; ?></strong></strong></h5>
        </center>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama konsumen</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tanggal pesan</th>
                    <th scope="col">Tanggal ambil</th>
                    <th scope="col">Jam ambil</th>
                    <th scope="col">Nama produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $cek = $koneksi->query("select * from v_keranjang where month(tgl_pesan) = '$bulan' and year(tgl_pesan) = '$tahun'  and status=5");
                while ($cek_row = $cek->fetch_assoc()) {
                ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $cek_row['nama_konsumen']; ?></td>
                        <td><?= $cek_row['alamat']; ?></td>
                        <td><?= date("d-m-Y", strtotime($cek_row['tgl_pesan'])); ?></td>
                        <td><?= date("d-m-Y", strtotime($cek_row['tgl_ambil'])); ?></td>
                        <td><?= date("H:i", strtotime($cek_row['jam_ambil'])); ?></td>
                        <td><?= $cek_row['nama_produk']; ?></td>
                        <td><?= rupiah($cek_row['harga']); ?></td>
                        <td><?= $cek_row['quantity_awal']; ?></td>
                        <td><?= rupiah($cek_row['total_bayar']); ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <?php
            $total = $koneksi->query("select sum(total_bayar) as total_bayar from v_keranjang where month(tgl_pesan) = '$bulan' and year(tgl_pesan) = '$tahun'  and status=5");
            $row_total = $total->fetch_assoc();
            $total_bayar = $row_total['total_bayar'];
            ?>
            <tfoot>
                <th colspan="8" style="text-align:center">TOTAL</th>
                <th><?= rupiah($total_bayar) ?></th>
            </tfoot>
        </table>
    <?php
    } else {
    ?>
        <center>
            <h5><strong>LAPORAN PEMESANAN</strong></h5>
        </center>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama konsumen</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tanggal pesan</th>
                    <th scope="col">Tanggal ambil</th>
                    <th scope="col">Jam ambil</th>
                    <th scope="col">Nama produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $cek = $koneksi->query("select * from v_keranjang where status=5");
                while ($cek_row = $cek->fetch_assoc()) {
                ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $cek_row['nama_konsumen']; ?></td>
                        <td><?= $cek_row['alamat']; ?></td>
                        <td><?= date("d-m-Y", strtotime($cek_row['tgl_pesan'])); ?></td>
                        <td><?= date("d-m-Y", strtotime($cek_row['tgl_ambil'])); ?></td>
                        <td><?= date("H:i", strtotime($cek_row['jam_ambil'])); ?></td>
                        <td><?= $cek_row['nama_produk']; ?></td>
                        <td><?= rupiah($cek_row['harga']); ?></td>
                        <td><?= $cek_row['quantity_awal']; ?></td>
                        <td><?= rupiah($cek_row['total_bayar']); ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <?php
            $total = $koneksi->query("select sum(total_bayar) as total_bayar from v_keranjang where status=5");
            $row_total = $total->fetch_assoc();
            $total_bayar = $row_total['total_bayar'];
            ?>
            <tfoot>
                <th colspan="8" style="text-align:center">TOTAL</th>
                <th><?= rupiah($total_bayar) ?></th>
            </tfoot>
        </table>
    <?php
    }
    ?>
</body>

</html>
<script>
    window.print();
</script>