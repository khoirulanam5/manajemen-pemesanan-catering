<h2>Ubah Data Bahan</h2>
<?php 
$ambil= $koneksi->query("SELECT * FROM bahan WHERE id_bahan='$_GET[id]'"); 
$pecah = $ambil->fetch_assoc();
?>
<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Bahan</label>
		<input type="text" class="form-control" name="bahan" value="<?php echo $pecah['nama_bahan'] ?>">
	</div>
	<div class="form-group">
		<label>Jumlah</label>
		<input type="text" class="form-control" name="jumlah" value="<?php echo $pecah['jumlah'] ?>">
	</div>
	<div class="form-group">
		<label>Harga</label>
		<input type="text" class="form-control" name="harga" value="<?php echo $pecah['harga'] ?>">
	</div>
	<div class="form-group">
		<label>Tanggal beli</label>
		<input type="date" class="form-control" name="tgl_beli" value="<?php echo $pecah['tgl_beli'] ?>">
	</div>
	<button class="btn btn-primary" name="ubah">Ubah</button>
</form>
<?php  
if (isset($_POST['ubah'])) 
	{
		$sql_ubah = "UPDATE bahan SET nama_bahan='$_POST[bahan]',jumlah='$_POST[jumlah]',harga='$_POST[harga]',tgl_beli='$_POST[tgl_beli]' WHERE id_bahan='$_GET[id]'";
        $query_ubah = mysqli_query($koneksi, $sql_ubah);
        mysqli_close($koneksi);
	

    if($query_ubah){
	echo "<script>alert('data telah diubah')</script>";
	echo "<script>location='index.php?halaman=bahan'</script>";
    }else{
    echo "<script>alert('data gagal diubah')</script>";
	echo "<script>location='index.php?halaman=bahan'</script>";
    }
}
?>