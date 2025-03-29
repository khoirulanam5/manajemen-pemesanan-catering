<h2>Kelola Resep</h2>
<a href="index.php?halaman=tambahresep" class="btn btn-primary">Tambah Data</a><br>
<br>
<?php
$nomor = 1;
$ambil = $koneksi->query("
    SELECT 
        r.id_produk, 
        p.nama_produk, 
        GROUP_CONCAT(CONCAT(b.nama_bahan, ' (', r.jml, ' ', r.satuan, ')') SEPARATOR ', ') AS bahan
    FROM resep r
    JOIN produk p ON r.id_produk = p.id_produk
    JOIN bahan b ON r.id_bahan = b.id_bahan
    GROUP BY r.id_produk
");
?>
<table id="example" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Resep</th>
            <th>Bahan</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $pecah['nama_produk']; ?></td>
                <td><?php echo $pecah['bahan']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
