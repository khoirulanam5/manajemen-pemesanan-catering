<h2>Ubah Barang</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM barang WHERE id_barang='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
?>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Barang</label>
		<input type="text" class="form-control" name="nama_barang" value="<?php echo $pecah['nama_barang'] ?>">
	</div>
	<div class="form-group">
		<label>Jenis</label>
		<input type="text" class="form-control" name="jenis" value="<?php echo $pecah['jenis'] ?>">
	</div>
	<div class="form-group">
		<label>Jumlah Barang</label>
		<input type="text" class="form-control" name="jumlah_brg" value="<?php echo $pecah['jumlah_brg'] ?>">
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
	<button class="btn btn-primary" name="ubah">Ubah</button>
</form>
<?php
if (isset($_POST['ubah'])) {
	$namafoto = $_FILES['foto']['name'];
	$lokasifoto = $_FILES['foto']['tmp_name'];
	if (!empty($lokasifoto)) {
		move_uploaded_file($lokasifoto, "../img/$namafoto");

		$koneksi->query("UPDATE barang SET nama_barang='$_POST[nama_barang]',jenis='$_POST[jenis]',jumlah_brg='$_POST[jumlah_brg]',harga='$_POST[harga]',foto='$namafoto' WHERE id_barang='$_GET[id]'");
	} else {
		$koneksi->query("UPDATE barang SET nama_barang='$_POST[nama_barang]',jenis='$_POST[jenis]',jumlah_brg='$_POST[jumlah_brg]',harga='$_POST[harga]' WHERE id_barang='$_GET[id]'");
	}
	echo "<script>alert('data telah diubah')</script>";
	echo "<script>location='index.php?halaman=barang'</script>";
}


?>