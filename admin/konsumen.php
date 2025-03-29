<h2>Kelola Konsumen</h2>
<div class="d-flex align-items-start">
    <a href="index.php?halaman=tambahkonsumen" class="btn btn-primary">Tambah Data</a><br>
    <a href="cetak_konsumen.php" class="btn btn-info" style="margin-left: 5px;">Cetak</a><br>
</div>
<br>
<table id="example" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Konsumen</th>
            <th>Username</th>
            <th>Password</th>
            <th>Alamat</th>
            <th>No. WA</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?php $nomor = 1; ?>
    <?php $ambil = $koneksi->query("SELECT * FROM konsumen"); ?>
    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_konsumen']; ?></td>
            <td><?php echo $pecah['username']; ?></td>
            <td><?php echo $pecah['password']; ?></td>
            <td><?php echo $pecah['alamat']; ?></td>
            <td><?php echo $pecah['no_telp']; ?></td>
            <td>
                <a href="index.php?halaman=konsumen&id=<?php echo $pecah['id_konsumen']; ?>" class="btn-danger btn" onclick="return(confirm('Anda yakin hapus data ini ?'))">hapus</a>
                <a href="index.php?halaman=ubahkonsumen&id=<?php echo $pecah['id_konsumen']; ?>" class="btn btn-warning">ubah</a>
            </td>
        </tr>
        <?php $nomor++; ?>
    <?php } ?>
    </tbody>
</table>

<?php
if (isset($_GET['id'])) {
    $hapus = $koneksi->query("DELETE FROM konsumen where id_konsumen='$_GET[id]'");

    if ($hapus) {
        echo "<script>alert('data telah dihapus')</script>";
        echo "<script>location='index.php?halaman=konsumen'</script>";
    }
}
?>