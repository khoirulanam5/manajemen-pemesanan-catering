<h2>Data Barang</h2>
<a href="index.php?halaman=tambahbarang" class="btn btn-primary">Tambah Data</a><br>
<br>
<table id="example" class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Barang</th>
			<th>Jenis</th>
			<th>Jumlah Barang</th>
			<th>Foto</th>
			<th>Harga</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<?php $nomor = 1; ?>
	<?php $ambil = $koneksi->query("SELECT * FROM barang"); ?>
	<?php while ($pecah = $ambil->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama_barang']; ?></td>
			<td><?php echo $pecah['jenis']; ?></td>
			<td><?php echo $pecah['jumlah_brg']; ?></td>
			<td><img src="../img/<?php echo $pecah['foto']; ?>" width="100"></td>
			<td><?php echo rupiah($pecah['harga']); ?></td>
			<td>
				<a href="index.php?halaman=hapusbarang&id=<?php echo $pecah['id_barang']; ?>" class="btn-danger btn">hapus</a>
				<a href="index.php?halaman=ubahbarang&id=<?php echo $pecah['id_barang']; ?>" class="btn btn-warning">ubah</a>
			</td>
		</tr>
		<?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>