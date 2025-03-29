<h2>Tambah Produk</h2>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Produk</label>
		<input type="text" class="form-control" name="nama_produk">
	</div>
	<div class="form-group">
		<label>Harga</label>
		<input type="number" class="form-control" name="harga">
	</div>
	<div class="form-group">
		<label>Foto</label>
		<input type="file" class="form-control" name="foto">
	</div>
	<div class="form-group">
		<label>Keterangan</label>
		<input type="text" class="form-control" name="keterangan">
	</div>
	<div class="form-group">
		<label>Kategori Produk</label>
		<select name="id_kategori_produk" class="form-control">
			<option disabled="" selected="">Pilih kategori produk</option>
			<?php
			$query_cek = $koneksi->query("select * from kategori_produk order by id_kategori_produk");
			while ($row_cek = $query_cek->fetch_assoc()) {
			?>
				<option value="<?= $row_cek['id_kategori_produk']; ?>"><?= $row_cek['kategori_produk']; ?></option>
			<?php
			}
			?>
		</select>
	</div>
	<button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {
	$nama = $_FILES['foto']['name'];
	$lokasi = $_FILES['foto']['tmp_name'];
	move_uploaded_file($lokasi, "../img/$nama");
	$koneksi->query("INSERT INTO produk (nama_produk,harga,foto,keterangan,id_kategori_produk)
	VALUES('$_POST[nama_produk]','$_POST[harga]','$nama','$_POST[keterangan]','$_POST[id_kategori_produk]')");
	echo "<div class='alert alert-info'>Data Tersimpan</div>";
	echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=produk'>";
}
?>