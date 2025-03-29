<?php
if (isset($_GET['id'])) {
    $idpinjam = $_GET['id'];
}
?>
<h2>Detail Pinjam Barang</h2>
<br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Foto Produk</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Total hari</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $cek = $koneksi->query("SELECT * from v_pinjam where id_peminjaman='$idpinjam' and status between '1' and '3'");
        while ($keranjang = $cek->fetch_assoc()) {
        ?>
            <tr>
                <th scope="row"><?= $no++; ?></th>
                <td><img src="../img/<?= $keranjang['foto']; ?>" alt="" width="50px"></td>
                <td><?= $keranjang['nama_barang']; ?></td>
                <td><?= rupiah($keranjang['harga']); ?></td>
                <td><?= $keranjang['total_hari']; ?></td>
                <td><?= $keranjang['quantity']; ?></td>
                <td><?= rupiah($keranjang['total_bayar']); ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php
$keranjang_v = $koneksi->query("SELECT sum(total_bayar) as total_bayar, id_peminjaman FROM v_pinjam where id_peminjaman='$idpinjam' and status between '1' and '3'");
$data_keranjang_v = $keranjang_v->fetch_assoc();
$total_bayar = $data_keranjang_v['total_bayar'];
?>
<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col" colspan="5" style="text-align: center;">TOTAL BAYAR</th>
            <th scope="col" style="text-align: center;"><?= rupiah($total_bayar); ?></th>
        </tr>
    </thead>
</table>
<br><br>
<h2>Rincian Pembayaran Pinjam Barang</h2>
<br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Tgl Bayar</th>
            <th scope="col">Tgl Pinjam</th>
            <th scope="col">Status Bayar</th>
            <th scope="col">Bukti</th>
            <th scope="col">Nominal Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $cek = $koneksi->query("SELECT * from v_pembayaran_pinjam where id_peminjaman='$idpinjam' and status between '0' and '3' group by id_pembayaran");
        while ($keranjang = $cek->fetch_assoc()) {
            $status_bayar = $keranjang['status_bayar'];
        ?>
            <tr>
                <th scope="row"><?= $no++; ?></th>
                <td><?= date("d-m-Y", strtotime($keranjang['tgl_bayar'])); ?></td>
                <td><?= date("d-m-Y", strtotime($keranjang['tgl_pinjam'])); ?></td>
                <td>
                    <?php
                    if ($status_bayar == "0" || $status_bayar == "1") {
                        echo $status_bayar = "DP";
                    } elseif ($status_bayar == "2" || $status_bayar == "3") {
                        echo $status_bayar = "Lunas";
                    }
                    ?>
                </td>
                <td><img src="../bukti/<?= $keranjang['bukti_pembayaran']; ?>" alt="" width="200px;"></td>
                <td><?= rupiah($keranjang['total']); ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php
$keranjang_v = $koneksi->query("SELECT sum(total) as total_bayar, id_peminjaman, id_pembayaran FROM pembayaran_pinjam where id_peminjaman='$idpinjam' and status_bayar between '0' and '3'");
$data_keranjang_v = $keranjang_v->fetch_assoc();
$total_bayar = $data_keranjang_v['total_bayar'];
?>
<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col" colspan="5" style="text-align: center;">NOMINAL BAYAR</th>
            <th scope="col" style="text-align: center;"><?= rupiah($total_bayar); ?></th>
        </tr>
    </thead>
</table>