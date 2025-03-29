<h2>Ubah Kategori Produk</h2>
<?php 
$ambil= $koneksi->query("SELECT * FROM kategori_produk WHERE id_kategori_produk='$_GET[id]'"); 
$pecah = $ambil->fetch_assoc();
?>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Kategori Produk</label>
		<input type="text" class="form-control" name="kategori_produk" value="<?php echo $pecah['kategori_produk'] ?>">
	</div>
	<button class="btn btn-primary" name="ubah">Ubah</button>
</form>
<?php  
if (isset($_POST['ubah'])) 
{
		$koneksi->query("UPDATE kategori_produk SET kategori_produk='$_POST[kategori_produk]' WHERE id_kategori_produk='$_GET[id]'");
	
	echo "<script>alert('data telah diubah')</script>";
	echo "<script>location='index.php?halaman=kategori-produk'</script>";
}
		

?>