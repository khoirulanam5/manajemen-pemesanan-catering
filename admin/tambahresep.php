<h2>Tambah Resep</h2>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Produk</label>
        <select name="id_produk" id="id_produk" class="form-control">
            <option selected="" disabled="">Pilih Produk</option>
            <?php
            $cekproduk = $koneksi->query("select * from produk");
            while ($dataproduk = $cekproduk->fetch_assoc()) {
            ?>
                <option value="<?= $dataproduk['id_produk']; ?>"><?= $dataproduk['nama_produk']; ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Bahan</label>
        <select name="id_bahan" id="id_bahan" class="form-control">
            <option selected="" disabled="">Pilih Bahan</option>
            <?php
            $cekbahan = $koneksi->query("select * from bahan");
            while ($databahan = $cekbahan->fetch_assoc()) {
            ?>
                <option value="<?= $databahan['id_bahan']; ?>"><?= $databahan['nama_bahan']; ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Jumlah</label>
        <input type="text" class="form-control" name="jml">
    </div>
    <div class="form-group">
        <label>Satuan</label>
        <input type="text" class="form-control" name="satuan">
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {
    $koneksi->query("INSERT INTO resep (id_produk,id_bahan,jml,satuan,id_resep)
	VALUES('$_POST[id_produk]','$_POST[id_bahan]','$_POST[jml]','$_POST[satuan]','$_POST[id_produk]')");
    echo "<div class='alert alert-info'>Data Tersimpan</div>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=resep'>";
}
?>