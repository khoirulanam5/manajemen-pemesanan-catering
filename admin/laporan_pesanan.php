<h2>Laporan Pemesanan</h2>
<a href="cetak_laporan_pemesanan.php" class="btn btn-primary">cetak</a><br>
<br>
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Id pesan</th>
            <th>Tgl pesan</th>
            <th>Total bayar</th>
            <th>Bukti Pembayaran</th>
            <th>Nama konsumen</th>
            <th>Alamat konsumen</th>
            <th>No wa</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?php $nomor = 1; ?>
    <?php $ambil = $koneksi->query("SELECT * FROM v_pembayaran where status=3"); ?>
    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
        <?php
        $idpemesanan = $pecah['id_pemesanan'];
        ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['id_pemesanan']; ?></td>
            <td><?php echo date("d-m-Y", strtotime($pecah['tgl_pesan'])); ?></td>
            <td><?php echo rupiah($pecah['total']); ?></td>
            <td>
                <img src="../bukti/<?php echo $pecah['bukti_pembayaran']; ?>" width="100">
            </td>
            <td><?php echo $pecah['nama_konsumen']; ?></td>
            <td><?php echo $pecah['alamat']; ?></td>
            <td><?php echo $pecah['no_telp']; ?></td>
            <td>
                <a href="cetak_nota.php?id=<?= $idpemesanan; ?>" class="btn-primary btn">cetak nota</a>
                <a href="index.php?halaman=detailpesanan&id=<?= $idpemesanan; ?>" class="btn-success btn">detail pesanan</a>
            </td>
        </tr>
        <?php $nomor++; ?>
    <?php } ?>
    </tbody>
</table>