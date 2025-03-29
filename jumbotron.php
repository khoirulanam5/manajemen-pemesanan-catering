<section class="py-5" style="background-image: url('img/foodbg1.jpg'); size: cover;">
     <div class="container px-4 px-lg-5 my-5">
         <div class="row">
             <div class="col-sm-4">
             <div class="card" style="width: 18rem; background-color: rgba(255, 255, 255, 0.7); /* Adjust opacity for desired transparency */ border-radius: 10px; box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15); overflow: hidden; /* Prevents background bleed on rounded corners */">
                <div class="card-header" style="background-color: #343a40; color: white; padding: 12px; text-align: center; font-weight: 600;">
                    JENIS MAKANAN
                </div>
                <ul class="list-group list-group-flush" style="margin-bottom: 0;">  <?php $ambil = $koneksi->query("SELECT * FROM kategori_produk where status='1'"); ?>
                    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                        <li class="list-group-item" style="background-color: transparent; padding: 12px; border-bottom: 1px solid rgba(0,0,0,0.1); /* Subtle separator lines */">
                            <a href="index.php?id=<?= $pecah['id_kategori_produk']; ?>" style="color: black; text-decoration: none; transition: color 0.3s ease; /* Smooth color transition */ display: block; /* Makes the whole li clickable */">
                                <?= $pecah['kategori_produk']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
             </div>
             <?php
                if (isset($_GET['id'])) {
                    $idkategoriproduk = $_GET['id'];
                    $produkk = $koneksi->query("SELECT * FROM v_produk where id_kategori_produk='$idkategoriproduk'");
                    $pecahh = $produkk->fetch_assoc();
                    $kategori_produk = $pecahh['kategori_produk'];
                }
                ?>
             <?php
                if ($produkk > 0) {
                ?>
                 <div class="col-sm-8" style="background-color: transparent;">
                     <div class="card text-center">
                         <div class="card-header">
                             <ul class="nav nav-tabs card-header-tabs">
                                 <li class="nav-item">
                                     <a class="nav-link active" href="javascript.void(0);"><?= $kategori_produk; ?></a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="?halaman=detailproduk&id=<?= $idkategoriproduk; ?>">More</a>
                                 </li>
                             </ul>
                         </div>
                         <div class="card-body">
                             <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                 <ol class="carousel-indicators">
                                     <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                     <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                     <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                 </ol>
                                 <div class="carousel-inner">
                                     <?php $nomor = 1; ?>
                                     <?php $ambil = $koneksi->query("SELECT * FROM v_produk where id_kategori_produk='$idkategoriproduk'"); ?>
                                     <?php while ($produk = $ambil->fetch_assoc()) { ?>
                                         <?php
                                            $id_produk = $produk['id_produk'];
                                            $img_produk = $produk['foto'];
                                            $nama_produk = $produk['nama_produk'];
                                            $hargaproduk = $produk['harga'];
                                            ?>
                                         <div class="carousel-item <?php if ($nomor <= 1) {
                                                                        echo " active ";
                                                                    } ?>">
                                             <img class="d-block w-100" src="img/<?= $produk['foto']; ?>" alt="First slide">
                                             <div class="carousel-caption d-none d-md-block">
                                                 <b>
                                                     <h3 style="color:white;"><?= strtoupper($produk['nama_produk']); ?></h5>
                                                 </b>
                                                 <b>
                                                     <h5 style="color:white;"><?= strtoupper(rupiah($produk['harga'])); ?></h6>
                                                 </b>
                                                 <?php
                                                    if ($data_user) {
                                                    ?>
                                                     <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#beli<?= $id_produk; ?>">Beli</button>

                                                 <?php
                                                    } else {
                                                    ?>
                                                     <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#belumlogin">Beli</button>
                                                 <?php
                                                    }
                                                    ?>
                                             </div>
                                         </div>
                                         <?php $nomor++; ?>
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
                                                         <button type="submit" name="tambah" class="btn btn-primary">Beli</button>
                                                     </div>
                                                     </form>
                                                 </div>
                                             </div>
                                         </div>
                                     <?php } ?>
                                 </div>
                                 <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                     <span class="sr-only">Previous</span>
                                 </a>
                                 <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                     <span class="sr-only">Next</span>
                                 </a>
                             </div>
                         </div>
                     </div>

                 </div>
             <?php
                } else {
                ?>
                 <div class="col-sm-8">
    <div class="jumbotron" style="background: transparent;">
        <h1 class="display-4" style="color: #f8f9fa; /* Light color for heading */ text-shadow: 2px 2px 4px #000000;">Lina Catering</h1>
        <hr class="my-4" style="border-top: 2px solid #6c757d; /* Slightly darker separator */">
        <h4 class="mb-3" style="color: #ced4da; /* Slightly lighter color for description */ text-shadow: 1px 1px 2px #000000;">Katering adalah layanan penyediaan makanan di lokasi terpencil atau di tempat, seperti penginapan, rumah sakit, bar, kapal pesiar, lokasi syuting atau studio, tempat hiburan, atau tempat acara. Pada era saat ini, orang-orang menghindari makan makanan berat.</h4>
    </div>
</div>
             <?php
                }
                ?>
         </div>
     </div>
 </section>