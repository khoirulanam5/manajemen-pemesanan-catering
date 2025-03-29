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
 <script>
     function sum() {
         var harga = document.getElementById('harga').value;
         var jml_beli = document.getElementById('jml_beli').value;
         var result = parseFloat(harga) * parseFloat(jml_beli);
         if (!isNaN(result)) {
             document.getElementById('total_harga').value = result;
         }
     }
 </script>
 <section class="py-5">
     <div class="container px-4 px-lg-5 my-5">
         <div class="row">
             <div class="col-sm-12">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>SEMUA PRODUK KATEGORI <?= strtoupper($kategori_produk); ?></b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <?php
                                $cekproduk = $koneksi->query("SELECT * FROM v_produk where id_kategori_produk='$idkategoriproduk'");
                                while ($produk = $cekproduk->fetch_assoc()) {
                                    $id_produk = $produk['id_produk'];
                                    $plus5 = $produk['id_produk'];
                                ?>
                                 <div class="col-sm-4">
                                     <div class="card" style="width: 18rem;">
                                         <img class="img-thumbnail" src="img/<?= $produk['foto']; ?>" alt="Card image cap">
                                         <div class="card-body">
                                             <h5 class="card-title"><?= strtoupper($produk['nama_produk']); ?></h5>
                                             <p class="card-text"><?= rupiah($produk['harga']); ?></p>
                                             <?php
                                                if ($data_user) {
                                                ?>
                                                 <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#beli<?= $id_produk; ?>">Pesan</a>
                                             <?php
                                                } else {
                                                ?>
                                                 <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#belumlogin">Pesan</button>
                                             <?php
                                                }
                                                ?>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="modal fade" id="beli<?= $id_produk; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                     <div class="modal-dialog" role="document">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h5 class="modal-title" id="exampleModalLabel">Halaman Order</h5>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                 </button>
                                             </div>
                                             <div class="modal-body">
                                                 <form method="post" action="simpankeranjang.php">
                                                     <div class="form-group row">
                                                         <label for="inputPassword" class="col-sm-2 col-form-label">Foto</label>
                                                         <div class="col-sm-10">
                                                             <img src="img/<?= $produk['foto']; ?>" width="200px" alt="">
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label for="inputPassword" class="col-sm-2 col-form-label">Produk</label>
                                                         <div class="col-sm-10">
                                                             <input type="hidden" name="nama_produk" value="<?= $produk['nama_produk']; ?>">
                                                             <input type="hidden" name="id_konsumen" value="<?= $data_id; ?>">
                                                             <input type="hidden" name="id_kategori_produk" value="<?= $idkategoriproduk; ?>">
                                                             <input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">
                                                             <input type="text" name="produk" class="form-control" value="<?= $produk['nama_produk']; ?>" required="" readonly>
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label for="inputPassword" class="col-sm-2 col-form-label">Harga</label>
                                                         <div class="col-sm-10">
                                                             <input type="hidden" id="harga" value="<?= $produk['harga']; ?>" onkeyup="sum();">
                                                             <input type="text" class="form-control" value="<?= rupiah($produk['harga']); ?>" required="" readonly>
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-2 col-form-label">Jumlah Pesan</label>
                                                        <div class="col-sm-5">
                                                            <?php $plus = "10" ?>
                                                            <?php $x_porsi = "1" ?>
                                                            <input type="hidden" value="<?= $x_porsi; ?>" id="plus3" class="plus3 form-control" readonly>
                                                            <input type="hidden" value="<?= $plus; ?>" id="plus1" class="plus1 form-control" readonly>
                                                            <input type="hidden" name="x_porsi" id="plus4" class="plus4 form-control" readonly>
                                                            <input type="number" name="jml_beli" id="plus2" class="plus2 form-control" value="<?= $plus; ?>" readonly>
                                                        </div>
                                                        <div class="col-sm-5 justify-content-between">
                                                            <button type="button" class="plus btn btn-info btn-sm">
                                                                <i class="fa fa-plus " aria-hidden="true"></i> Tambah
                                                            </button>
                                                            <button type="button" class="minus btn btn-danger btn-sm">
                                                                <i class="fa fa-minus " aria-hidden="true"></i> Kurang
                                                            </button>
                                                        </div>
                                                        <small><strong>Minimal Beli : 10</strong></small>
                                                    </div>
                                             </div>
                                             <div class="modal-footer">
                                                 <button type="button" class="hapus btn btn-secondary" data-dismiss="modal">Close</button>
                                                 <button type="submit" name="tambah" class="btn btn-primary">Pesan</button>
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