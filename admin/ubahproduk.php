<h2>Ubah Produk</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM v_produk WHERE id_produk='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
$kategori_produk = $pecah['kategori_produk'];
?>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Produk</label>
		<input type="text" class="form-control" name="nama_produk" value="<?php echo $pecah['nama_produk'] ?>">
	</div>
	<div class="form-group">
		<label>Kategori Produk <b>(Kategori produk : <?= $kategori_produk; ?>)</b></label>
		<select name="id_kategori_produk" class="form-control">
			<option disabled="" selected="">Pilih kategori produk</option>
			<?php
			$query_cek = $koneksi->query("select * from kategori_produk");
			while ($row_cek = $query_cek->fetch_assoc()) {
			?>
				<option value="<?= $row_cek['id_kategori_produk']; ?>"><?= $row_cek['kategori_produk']; ?></option>
			<?php
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label>Harga</label>
		<input type="text" class="form-control" name="harga" value="<?php echo $pecah['harga'] ?>">
	</div>
	<div class="form-group">
		<img src="../img/<?php echo $pecah['foto'] ?>" width="200">
	</div>
	<div class="form-group">
		<label>Ganti Foto</label>
		<input type="file" class="form-control" name="foto">
	</div>
	<div class="form-group">
		<label>Keterangan</label>
		<input type="text" class="form-control" name="keterangan" value="<?php echo $pecah['keterangan'] ?>">
	</div>
	<button class="btn btn-primary" name="ubah">Ubah</button>
</form>
<?php
if (isset($_POST['ubah'])) {
	$namafoto = $_FILES['foto']['name'];
	$lokasifoto = $_FILES['foto']['tmp_name'];
	if (!empty($lokasifoto)) {
		move_uploaded_file($lokasifoto, "../img/$namafoto");

		$koneksi->query("UPDATE produk SET nama_produk='$_POST[nama_produk]',id_kategori_produk='$_POST[id_kategori_produk]',harga='$_POST[harga]',foto='$namafoto',keterangan='$_POST[keterangan]' WHERE id_produk='$_GET[id]'");
	} else {
		$koneksi->query("UPDATE produk SET nama_produk='$_POST[nama_produk]',id_kategori_produk='$_POST[id_kategori_produk]',harga='$_POST[harga]' WHERE id_produk='$_GET[id]'");
	}
	echo "<script>alert('data telah diubah')</script>";
	echo "<script>location='index.php?halaman=produk'</script>";
}


?>