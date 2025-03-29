<?php
include "config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Barang</title>
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
    <center>
        <h5><strong>LAPORAN DATA BARANG</strong></h5>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Jumlah Barang</th>
                <th scope="col">Harga</th>
                <th scope="col">Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $cek = $koneksi->query("select * from barang");
            while ($cek_row = $cek->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $cek_row['nama_barang']; ?></td>
                    <td><?= $cek_row['jumlah_brg']; ?></td>
                    <td><?= rupiah($cek_row['harga']); ?></td>
                    <td><img src="../img/<?= $cek_row['foto']; ?>" alt="" width="60px;"></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
<script>
    window.print();
</script>