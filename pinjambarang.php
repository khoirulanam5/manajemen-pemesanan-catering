 <?php
    if (isset($_GET['id'])) {
        $idkategoriproduk = $_GET['id'];
        $cek_kategori_produk = $koneksi->query("select * from v_produk where id_kategori_produk='$idkategoriproduk'");
        $data_produk = $cek_kategori_produk->fetch_assoc();
        $nama_produk = $data_produk['nama_produk'];
        $harga = $data_produk['harga'];
        $idproduk = $data_produk['id_produk'];
        $kategori_produk = $data_produk['kategori_produk'];
    }
    ?>

 <section class="py-5">
     <div class="container px-4 px-lg-5 my-5">
         <div class="row">
             <div class="col-sm-12">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>SEMUA BARANG YANG TERSEDIA DIPINJAMKAN</b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <?php
                                $cekproduk = $koneksi->query("SELECT * FROM barang");
                                while ($produk = $cekproduk->fetch_assoc()) {
                                    $id_barang = $produk['id_barang'];
                                ?>
                                 <div class="col-sm-4">
                                     <div class="card" style="width: 18rem;">
                                         <img class="img-thumbnail" src="img/<?= $produk['foto']; ?>" alt="Card image cap">
                                         <div class="card-body">
                                             <h4 class="card-title"><?= strtoupper($produk['nama_barang']); ?></h4>
                                             <h6 class="card-text">Stok Barang : <?= $produk['jumlah_brg']; ?></h6>
                                             <p class="card-text"><?= rupiah($produk['harga']); ?></p>
                                             <?php
                                                if ($data_user) {
                                                ?>
                                                 <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#beli<?= $id_barang; ?>">Pinjam</a>
                                             <?php
                                                } else {
                                                ?>
                                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#belumlogin">Pinjam</button>
                                             <?php
                                                }
                                                ?>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="modal fade" id="beli<?= $id_barang; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                     <div class="modal-dialog modal-dialog-scrollable" role="document">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h5 class="modal-title" id="exampleModalLabel">Pinjam Barang</h5>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                 </button>
                                             </div>
                                             <div class="modal-body">
                                                 <form method="post" action="pinjam.php">
                                                     <div class="form-group row">
                                                         <label for="inputPassword" class="col-sm-3 col-form-label">Poto</label>
                                                         <div class="col-sm-9">
                                                             <img src="img/<?= $produk['foto']; ?>" width="200px" alt="">
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label for="inputPassword" class="col-sm-3 col-form-label">Barang</label>
                                                         <div class="col-sm-9">
                                                             <input type="hidden" name="nama_barang" value="<?= $produk['nama_barang']; ?>">
                                                             <input type="hidden" name="id_konsumen" value="<?= $data_id; ?>">
                                                             <input type="hidden" name="id_barang" value="<?= $produk['id_barang']; ?>">
                                                             <input type="text" name="barang" class="form-control" value="<?= $produk['nama_barang']; ?>" required="" readonly>
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label for="inputPassword" class="col-sm-3 col-form-label">Stok Barang</label>
                                                         <div class="col-sm-9">
                                                             <input type="text" class="form-control" value="<?= $produk['jumlah_brg']; ?>" required="" readonly>
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label for="inputPassword" class="col-sm-3 col-form-label">Harga</label>
                                                         <div class="col-sm-9">
                                                             <input type="hidden" id="harga" value="<?= $produk['harga']; ?>" onkeyup="sum();">
                                                             <input type="text" class="form-control" value="<?= rupiah($produk['harga']); ?>" required="" readonly>
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label for="staticEmail" class="col-sm-3 col-form-label">Jumlah Pinjam</label>
                                                         <div class="col-sm-9">
                                                             <input type="number" name="jml_pinjam" id="jml_pinjam" class="form-control" placeholder="Jumlah pinjam.." required="" autofocus onkeyup="sum();">
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label for="staticEmail" class="col-sm-3 col-form-label">Berapa hari</label>
                                                         <div class="col-sm-9">
                                                             <input type="number" name="total_hari" id="total_hari" class="form-control" placeholder="Berapa hari.." required="" autofocus onkeyup="sum();">
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label for="staticEmail" class="col-sm-3 col-form-label">Tgl kembali</label>
                                                         <div class="col-sm-9">
                                                             <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" required="" autofocus onkeyup="sum();">
                                                         </div>
                                                     </div>
                                             </div>
                                             <div class="modal-footer">
                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                 <button type="submit" name="pinjam" class="btn btn-primary">Pinjam</button>
                                             </div>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             <?php
                                }
                                ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>