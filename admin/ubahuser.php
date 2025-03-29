<h2>Ubah Data User</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM user WHERE id_user='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Pengguna</label>
        <input type="text" class="form-control" name="nama" value="<?php echo $pecah['nama_pengguna'] ?>">
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
        <label>Level <b>(Level : <?= $pecah['level']; ?>)</b></label>
        <select name="level" class="form-control">
            <option disabled="" selected="">Pilih level</option>
            <option value="Pemilik">Pemilik</option>
            <option value="Kasir">Kasir</option>
            <option value="Dapur">Dapur</option>
        </select>
    </div>
    <button class="btn btn-primary" name="ubah">Ubah</button>
</form>
<?php
if (isset($_POST['ubah'])) {
    error_reporting(0);
    $level = $_POST['level'];
    if ($level == "") {
        $level = $pecah['level'];
    }
    $sql_ubah = "UPDATE user SET nama_pengguna='$_POST[nama]',username='$_POST[username]',password='$_POST[password]',level='$level' WHERE id_user='$_GET[id]'";
    $query_ubah = mysqli_query($koneksi, $sql_ubah);
    mysqli_close($koneksi);


    if ($query_ubah) {
        echo "<script>alert('data telah diubah')</script>";
        echo "<script>location='index.php?halaman=user'</script>";
    } else {
        echo "<script>alert('data gagal diubah')</script>";
        echo "<script>location='index.php?halaman=user'</script>";
    }
}
?>