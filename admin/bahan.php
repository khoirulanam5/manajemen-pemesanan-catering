<h2>Kelola Bahan</h2>
<a href="index.php?halaman=tambahbahan" class="btn btn-primary">Tambah Data</a><br>
<br>
<table id="example" class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Bahan</th>
			<th>Jumlah (g)</th>
			<th>Harga</th>
			<th>Tanggal Beli</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<?php $nomor = 1; ?>
	<?php $ambil = $koneksi->query("SELECT * FROM bahan"); ?>
	<?php while ($pecah = $ambil->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama_bahan']; ?></td>
			<td><?php echo $pecah['jumlah']; ?></td>
			<td><?php echo $pecah['harga']; ?></td>
			<td><?php echo do_formal_date($pecah['tgl_beli']); ?></td>
			<td>
				<a href="index.php?halaman=hapusbahan&id=<?php echo $pecah['id_bahan']; ?>" class="btn-danger btn">hapus</a>
				<a href="index.php?halaman=ubahbahan&id=<?php echo $pecah['id_bahan']; ?>" class="btn btn-warning">ubah</a>
			</td>
		</tr>
		<?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>