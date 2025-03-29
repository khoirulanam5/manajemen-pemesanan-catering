<h2>Laporan Peminjaman</h2>
<a href="cetak_laporan_pinjam.php" class="btn btn-primary">cetak</a><br>
<br>
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Id pinjam</th>
            <th>Tgl pinjam</th>
            <th>Total harga</th>
            <th>Bukti Pembayaran</th>
            <th>Nama konsumen</th>
            <th>Alamat konsumen</th>
            <th>No wa</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?php $nomor = 1; ?>
    <?php $ambil = $koneksi->query("SELECT * FROM v_pembayaran_pinjam where status='3' group by id_peminjaman"); ?>
    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
        <?php
        $idpeminjaman = $pecah['id_peminjaman'];
        ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['id_peminjaman']; ?></td>
            <td><?php echo date("d-m-Y", strtotime($pecah['tgl_pinjam'])); ?></td>
            <td><?php echo rupiah($pecah['total_harga']); ?></td>
            <td>
                <img src="../bukti/<?php echo $pecah['bukti_pembayaran']; ?>" width="100">
            </td>
            <td><?php echo $pecah['nama_konsumen']; ?></td>
            <td><?php echo $pecah['alamat']; ?></td>
            <td><?php echo $pecah['no_telp']; ?></td>
            <td>
                <a href="cetak_nota_pinjam.php?id=<?= $idpeminjaman; ?>" class="btn-primary btn">cetak nota</a>
                <a href="index.php?halaman=detailpinjam&id=<?= $idpeminjaman; ?>" class="btn-success btn">detail barang pinjam</a>
            </td>
        </tr>
        <?php $nomor++; ?>
    <?php } ?>
    </tbody>
</table>