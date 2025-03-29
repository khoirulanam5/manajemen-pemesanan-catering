<h2>Tambah Produk</h2>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Kategori Produk</label>
		<input type="text" class="form-control" name="kategori_produk" placeholder="Kategori produk..">
	</div>
	<button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save']))
{
	$koneksi->query("INSERT INTO kategori_produk (kategori_produk)
	VALUES('$_POST[kategori_produk]') ");
	echo "<div class='alert alert-info'>Data Tersimpan</div>";
	echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=kategori-produk'>";
}
?>