<h2>Tambah User</h2>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama User</label>
        <input type="text" class="form-control" name="nama">
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" name="password">
    </div>
    <div class="form-group">
        <label>Level</label>
        <select name="level" class="form-control">
            <option value="Pemilik">Pemilik</option>
            <option value="Kasir">Kasir</option>
            <option value="Gudang">Gudang</option>
        </select>
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {
    $koneksi->query("INSERT INTO user (nama_pengguna,username,password,level)
	VALUES('$_POST[nama]','$_POST[username]','$_POST[password]','$_POST[level]')");
    echo "<div class='alert alert-info'>Data Tersimpan</div>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=user'>";
}
?>