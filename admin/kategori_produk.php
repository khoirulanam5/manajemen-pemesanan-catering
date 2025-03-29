<h2>Kategori Produk</h2>
<a href="index.php?halaman=tambahkategoriproduk" class="btn btn-primary">Tambah Data</a><br>
<br>
<table id="example" class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Kategori Produk</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<?php $nomor = 1; ?>
	<?php $ambil = $koneksi->query("SELECT * FROM kategori_produk"); ?>
	<?php while ($pecah = $ambil->fetch_assoc()) { ?>
		<?php $status = $pecah['status']; ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['kategori_produk']; ?></td>
			<td>
				<?php
				if ($status == "1") {
				?>
					<a href="index.php?halaman=kategori-produk&nonaktif=<?php echo $pecah['id_kategori_produk']; ?>" onclick="return(confirm('Apakah anda yakin menonaktikan kategori ini ?'))" class="btn-secondary btn">non-aktif</a>
				<?php
				} else {
				?>
					<a href="index.php?halaman=kategori-produk&aktif=<?php echo $pecah['id_kategori_produk']; ?>" onclick="return(confirm('Apakah anda yakin mengaktifkan kategori ini ?'))" class="btn-primary btn">aktif</a>
				<?php
				}
				?>
				<a href="index.php?halaman=kategori-produk&id=<?php echo $pecah['id_kategori_produk']; ?>" onclick="return(confirm('Apakah anda yakin hapus data ini ?'))" class="btn-danger btn">hapus</a>
				<a href="index.php?halaman=ubahkategoriproduk&id=<?php echo $pecah['id_kategori_produk']; ?>" class="btn btn-warning">ubah</a>
			</td>
		</tr>
		<?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>

<?php
if (isset($_GET['id'])) {
	$koneksi->query("DELETE FROM kategori_produk WHERE id_kategori_produk='$_GET[id]'");

	echo "<script>alert('data telah dihapus')</script>";
	echo "<script>location='index.php?halaman=kategori-produk'</script>";
} elseif (isset($_GET['nonaktif'])) {
	$koneksi->query("UPDATE kategori_produk set status='0' where id_kategori_produk='$_GET[nonaktif]'");
	echo "<script>alert('data telah dinonaktifkan')</script>";
	echo "<script>location='index.php?halaman=kategori-produk'</script>";
} elseif (isset($_GET['aktif'])) {
	$koneksi->query("UPDATE kategori_produk set status='1' where id_kategori_produk='$_GET[aktif]'");
	echo "<script>alert('data telah dinaktifkan')</script>";
	echo "<script>location='index.php?halaman=kategori-produk'</script>";
}
?>