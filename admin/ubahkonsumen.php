<h2>Ubah Data User</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM konsumen WHERE id_konsumen='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Pengguna</label>
        <input type="text" class="form-control" name="nama" value="<?php echo $pecah['nama_konsumen'] ?>">
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $pecah['username'] ?>">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" name="password" value="<?php echo $pecah['password'] ?>">
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <input type="text" class="form-control" name="alamat" value="<?php echo $pecah['alamat'] ?>">
    </div>
    <div class="form-group">
        <label>WA</label>
        <input type="text" class="form-control" name="wa" value="<?php echo $pecah['no_telp'] ?>">
    </div>
    <button class="btn btn-primary" name="ubah">Ubah</button>
</form>
<?php
if (isset($_POST['ubah'])) {
    error_reporting(0);
    $sql_ubah = "UPDATE konsumen SET nama_konsumen='$_POST[nama]',username='$_POST[username]',password='$_POST[password]',alamat='$_POST[alamat]',no_telp='$_POST[wa]' WHERE id_konsumen='$_GET[id]'";
    $query_ubah = mysqli_query($koneksi, $sql_ubah);
    mysqli_close($koneksi);


    if ($query_ubah) {
        echo "<script>alert('data telah diubah')</script>";
        echo "<script>location='index.php?halaman=konsumen'</script>";
    } else {
        echo "<script>alert('data gagal diubah')</script>";
        echo "<script>location='index.php?halaman=konsumen'</script>";
    }
}
?>