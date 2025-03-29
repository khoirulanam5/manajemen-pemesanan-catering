<?php
include "config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Konsumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <center>
        <h4>LAPORAN DATA KONSUMEN</h4>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama konsumen</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. WA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $cek = $koneksi->query("select * from konsumen");
            while ($cek_row = $cek->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $cek_row['nama_konsumen']; ?></td>
                    <td><?= $cek_row['alamat']; ?></td>
                    <td><?= $cek_row['no_telp']; ?></td>
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