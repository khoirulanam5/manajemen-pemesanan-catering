<?php
include "config/koneksi.php";
if (isset($_GET['id'])) {
    $idpemesanan = $_GET['id'];
    $cek = $koneksi->query("SELECT * from v_pinjam where id_peminjaman='$idpemesanan'");
    $cek_row = $cek->fetch_assoc();
    $nama_konsumen = $cek_row['nama_konsumen'];
    $alamat = $cek_row['alamat'];
    $no_wa = $cek_row['no_telp'];
    $tgl_pinjam = $cek_row['tgl_pinjam'];
    $tgl_kembali = $cek_row['tgl_kembali'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cetak nota pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            text-align: center;
        }

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
    <center>
        <h5><strong>Nota Peminjaman Barang</strong></h5>
    </center>
    <table border=1>
        <tr>
            <th>Nama</th>
            <th style="text-align: center;">:</th>
            <th><?= $nama_konsumen; ?></th>
        </tr>
        <tr>
            <th>Alamat</th>
            <th style="text-align: center;">:</th>
            <th><?= $alamat; ?></th>
        </tr>
        <tr>
            <th>No. WA</th>
            <th style="text-align: center;">:</th>
            <th><?= $no_wa; ?></th>
        </tr>
        <tr>
            <th>Tgl pinjam</th>
            <th style="text-align: center;">:</th>
            <th><?= date("d-m-Y", strtotime($tgl_pinjam)); ?></th>
        </tr>
        <tr>
            <th>Tgl kembali</th>
            <th style="text-align: center;">:</th>
            <th><?= date("d-m-Y", strtotime($tgl_kembali)); ?></th>
        </tr>
        <tr>
            <th>ID pinjam</th>
            <th style="text-align: center;">:</th>
            <th><?= $idpemesanan; ?></th>
        </tr>
    </table><br><br>
    <h4>*barang yang dipinjam.</h4>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No.</th>
                <th>Foto barang</th>
                <th>Nama barang</th>
                <th>Harga</th>
                <th>Total hari</th>
                <th>Qty</th>
                <th>Total harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $cek_produk = $koneksi->query("SELECT * from v_pinjam where id_peminjaman='$idpemesanan'");
            while ($produk = $cek_produk->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><img src="../img/<?= $produk['foto']; ?>" alt="" width="50px;"></td>
                    <td><?= $produk['nama_barang']; ?></td>
                    <td><?= rupiah($produk['harga']); ?></td>
                    <td><?= $produk['total_hari']; ?></td>
                    <td><?= $produk['quantity']; ?></td>
                    <td><?= rupiah($produk['total_bayar']); ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <?php
        $total = $koneksi->query("SELECT sum(total_bayar) as total_bayar from v_pinjam where id_peminjaman='$idpemesanan'");
        $row_total = $total->fetch_assoc();
        $total_bayar = $row_total['total_bayar'];
        ?>
        <tfoot>
            <th colspan="6" style="text-align:center">TOTAL</th>
            <th style="text-align:center"><?= rupiah($total_bayar) ?></th>
        </tfoot>
    </table><br><br>
    <h4>*rincian pembayaran pinjam barang.</h4>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No.</th>
                <th>Tgl bayar</th>
                <th>Tgl pinjam</th>
                <th>Status bayar</th>
                <th>Bukti bayar</th>
                <th>Nominal bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $cek_produk = $koneksi->query("select * from v_pembayaran_pinjam where id_peminjaman='$idpemesanan' order by id_pembayaran desc");
            while ($produk = $cek_produk->fetch_assoc()) {
                $status_bayar = $produk['status_bayar'];
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date("d-m-Y", strtotime($produk['tgl_bayar'])); ?></td>
                    <td><?= date("d-m-Y", strtotime($produk['tgl_pinjam'])); ?></td>
                    <td>
                        <?php
                        if ($status_bayar == "2" || $status_bayar == "3") {
                            echo $status_bayar = "Lunas";
                        } elseif ($status_bayar == "1") {
                            echo $status_bayar = "DP";
                        } else {
                            echo $status_bayar = "DP";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($produk['bukti_pembayaran'] == "") {
                            echo "sudah bayar ditempat.";
                        } else {
                        ?>
                            <img src="../bukti/<?= $produk['bukti_pembayaran']; ?>" alt="" width="100px;">
                        <?php
                        }
                        ?>
                    </td>
                    <td><?= rupiah($produk['total']); ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <?php
        $total = $koneksi->query("select sum(total_bayar) as total_bayar from v_pinjam where id_peminjaman='$idpemesanan'");
        $row_total = $total->fetch_assoc();
        $total_bayar = $row_total['total_bayar'];
        ?>
        <tfoot>
            <th colspan="5" style="text-align:center">TOTAL</th>
            <th style="text-align:center"><?= rupiah($total_bayar) ?></th>
        </tfoot>
    </table>
</body>

</html>
<script>
    window.print();
</script>