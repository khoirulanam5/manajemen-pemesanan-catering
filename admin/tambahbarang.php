<h2>Tambah Barang</h2>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Barang</label>
		<input type="text" class="form-control" name="barang">
	</div>
	<div class="form-group">
		<label>Jenis</label>
		<input type="text" class="form-control" name="jenis">
	</div>
	<div class="form-group">
		<label>Jumlha</label>
		<input type="text" class="form-control" name="jumlah">
	</div>
	<div class="form-group">
		<label>Foto</label>
		<input type="file" class="form-control" name="foto">
	</div>
	<div class="form-group">
		<label>Harga</label>
		<input type="text" class="form-control" name="harga">
	</div>
	<button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {
	$nama = $_FILES['foto']['name'];
	$lokasi = $_FILES['foto']['tmp_name'];
	move_uploaded_file($lokasi, "../img/$nama");
	$koneksi->query("INSERT INTO barang (nama_barang,jenis,jumlah_brg,foto,harga)
	VALUES('$_POST[barang]','$_POST[jenis]','$_POST[jumlah]','$nama','$_POST[harga]') ");
	echo "<div class='alert alert-info'>Data Tersimpan</div>";
	echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=barang'>";
}
?>