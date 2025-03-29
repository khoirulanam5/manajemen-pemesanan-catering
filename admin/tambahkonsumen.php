<h2>Tambah Konsumen</h2>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Konsumen</label>
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
        <label>Alamat</label>
        <input type="text" class="form-control" name="alamat">
    </div>
    <div class="form-group">
        <label>No. WA</label>
        <input type="text" class="form-control" name="wa">
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {
    $no_wa = $_POST['wa'];
    $wa = '62' . substr($no_wa, 1, 100000);
    $koneksi->query("INSERT INTO konsumen (nama_konsumen,username,password,alamat,no_telp)
	VALUES('$_POST[nama]','$_POST[username]','$_POST[password]','$_POST[alamat]','$wa')");
    echo "<div class='alert alert-info'>Data Tersimpan</div>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=konsumen'>";
}
?>