<h2>Produk</h2>
<a href="index.php?halaman=tambahproduk" class="btn btn-primary">Tambah Data</a><br>
<br>
<table id="example" class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Produk</th>
			<th>Jenis</th>
			<th>Harga</th>
			<th>Foto</th>
			<th>Keterangan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<?php $nomor = 1; ?>
	<?php $ambil = $koneksi->query("SELECT * FROM v_produk order by id_produk desc"); ?>
	<?php while ($pecah = $ambil->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama_produk']; ?></td>
			<td><?php echo $pecah['kategori_produk']; ?></td>
			<td><?php echo $pecah['harga']; ?></td>
			<td>
				<img src="../img/<?php echo $pecah['foto']; ?>" width="100">
			</td>
			<td><?php echo $pecah['keterangan']; ?></td>
			<td>
				<a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn-danger btn">hapus</a>
				<a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn btn-warning">ubah</a>
			</td>
		</tr>
		<?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>