<h2>Kelola User</h2>
<a href="index.php?halaman=tambahuser" class="btn btn-primary">Tambah Data</a><br>
<br>
<table id="example" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pengguna</th>
            <th>Username</th>
            <th>Password</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?php $nomor = 1; ?>
    <?php $ambil = $koneksi->query("SELECT * FROM user"); ?>
    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_pengguna']; ?></td>
            <td><?php echo $pecah['username']; ?></td>
            <td><?php echo $pecah['password']; ?></td>
            <td><?php echo $pecah['level']; ?></td>
            <td>
                <a href="index.php?halaman=user&id=<?php echo $pecah['id_user']; ?>" class="btn-danger btn" onclick="return(confirm('Anda yakin hapus data ini ?'))">hapus</a>
                <a href="index.php?halaman=ubahuser&id=<?php echo $pecah['id_user']; ?>" class="btn btn-warning">ubah</a>
            </td>
        </tr>
        <?php $nomor++; ?>
    <?php } ?>
    </tbody>
</table>

<?php
if (isset($_GET['id'])) {
    $hapus = $koneksi->query("DELETE FROM user where id_user='$_GET[id]'");

    if ($hapus) {
        echo "<script>alert('data telah dihapus')</script>";
        echo "<script>location='index.php?halaman=user'</script>";
    }
}
?>