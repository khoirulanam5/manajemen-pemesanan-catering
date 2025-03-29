<h2>Tambah Bahan</h2>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Bahan</label>
		<input type="text" class="form-control" name="bahan">
	</div>
	<div class="form-group">
		<label>Jumlah</label>
		<input type="number" class="form-control" name="jumlah">
	</div>
	<div class="form-group">
		<label>Harga</label>
		<input type="number" class="form-control" name="harga">
	</div>
    <div class="form-group">
		<label>Tanggal beli</label>
		<input type="date" class="form-control" name="tgl_beli">
	</div>
	<button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save']))
{
	$koneksi->query("INSERT INTO bahan (nama_bahan,jumlah,harga,tgl_beli)
	VALUES('$_POST[bahan]','$_POST[jumlah]','$_POST[harga]','$_POST[tgl_beli]')");
	echo "<div class='alert alert-info'>Data Tersimpan</div>";
	echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=bahan'>";
}
?>