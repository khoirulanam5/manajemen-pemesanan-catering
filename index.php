<?php
session_start();
include "admin/config/koneksi.php";
error_reporting(0);
// header("location: http://localhost/catering/admin/index.php?id=1");
// die();
if (isset($_SESSION["ses_username"]) == "") {
    header("location: ");
} else {
    $data_user = $_SESSION["ses_username"];
    $data_id = $_SESSION["ses_id"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Lina Catering</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="img/DM.PNG" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
</head>

<body>
    <!-- Navigation-->
    <style>
        /* Modify the background color */
        .navbar-custom {
            background-color: #Edcb3c;
        }

        .img-thumbnail {
            width: 900px;
            height: 300px;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container px-4 px-lg-5">
            <a href="./admin/login.php"><b>LINA CATERING</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= $home; ?>">Home</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="?halaman=pinjambarang">Pinjam Barang</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="?halaman=riwayat">Riwayat Pemesanan</a></li>

                </ul>
                <ul class="navbar-nav ml-auto mb-auto">
                    <?php
                    if ($data_user) {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="?halaman=profil"><?= $data_user; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php" onclick="return(confirm('Anda yakin ingin logout ?'))">Logout</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="javascript.void(0)" data-toggle="modal" data-target="#exampleModal">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="javascript.void(0)" data-toggle="modal" data-target="#register">Register</a></li>
                    <?php
                    }
                    ?>
                </ul>
                <?php
                $cek_ = $koneksi->query("SELECT * FROM v_keranjang where id_konsumen='$data_id' and status='0'");
                $rows = $cek_->num_rows;
                $cek_2 = $koneksi->query("SELECT * FROM v_pinjam where id_konsumen='$data_id' and status='0'");
                $rows2 = $cek_2->num_rows;
                $cek_bayar = $koneksi->query("SELECT * FROM v_pembayaran where id_konsumen='$data_id' and status='1'");
                $rows_bayar = $cek_bayar->num_rows;
                $cek_bayar2 = $koneksi->query("SELECT * FROM peminjaman where id_konsumen='$data_id' and status between '1' and '2'");
                $rows_bayar2 = $cek_bayar2->num_rows;
                $cek_bayar1 = $koneksi->query("SELECT * FROM pemesanan where id_konsumen='$data_id' and status between '1' and '2'");
                $rows_bayar1 = $cek_bayar1->num_rows;
                $cek_brg_pinjam = $koneksi->query("SELECT * FROM v_pinjam where id_konsumen='$data_id' and status between '1' and '3' GROUP BY id_peminjaman");
                $jmlbrgpinjam = $cek_brg_pinjam->num_rows;
                ?>
                <?php
                if ($data_user) {
                ?>
                    <form class="d-flex">
                        <a href="?halaman=keranjang" class="btn btn-outline-dark">
                            <i class="bi-cart-fill me-1"></i>
                            <span class="badge bg-dark text-white ms-1 rounded-pill">
                                <?php
                                if ($rows && $rows2) {
                                    echo $rows + $rows2;
                                } elseif ($rows) {
                                    echo $rows;
                                } elseif ($rows2) {
                                    echo $rows2;
                                } else {
                                    echo '0';
                                }
                                ?>
                            </span>
                        </a>
                        <a href="?halaman=proses" class="btn btn-outline-dark">
                            <i class="bi bi-chat-left-dots-fill me-1"></i>
                            <span class="badge bg-dark text-white ms-1 rounded-pill">
                                <?php
                                if ($rows_bayar1 && $rows_bayar2) {
                                    echo $rows_bayar1 + $rows_bayar2;
                                } elseif ($rows_bayar1) {
                                    echo $rows_bayar1;
                                } elseif ($rows_bayar2) {
                                    echo $rows_bayar2;
                                } else {
                                    echo '0';
                                }
                                ?>
                            </span>
                        </a>
                    </form>
                <?php
                } else {
                ?>
                    <form class="d-flex">
                        <a href="javascript.void(0)" class="btn btn-outline-dark" data-toggle="modal" data-target="#belumlogin">
                            <i class="bi-cart-fill me-1"></i>
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </a>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <?php
    if (isset($_GET['halaman'])) {
        if ($_GET['halaman'] == "profil") {
            include 'profil.php';
        } else if ($_GET['halaman'] == "editprofil") {
            include 'edit_profil.php';
        } else if ($_GET['halaman'] == "detailproduk") {
            include 'detail_produk.php';
        } else if ($_GET['halaman'] == "keranjang") {
            include 'keranjang.php';
        } else if ($_GET['halaman'] == "proses") {
            include 'proses.php';
        } else if ($_GET['halaman'] == "pinjambarang") {
            include 'pinjambarang.php';
        } else if ($_GET['halaman'] == "riwayat") {
            include 'riwayat.php';
        } else if ($_GET['halaman'] == "detail") {
            include 'detail.php';
        } else if ($_GET['halaman'] == "detailpinjam") {
            include 'detailpinjam.php';
        } else if ($_GET['halaman'] == "jmlbrgpinjam") {
            include 'jmlbrgpinjam.php';
        }
    } else
        include 'jumbotron.php';
    if ($data_level == "Pemilik") {
        include "home/pemilik.php";
    }
    ?>

    <!-- Footer-->

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-warning">Lina Catering @<?= date('Y'); ?></p>
        </div>
    </footer>
    <div class="modal fade" id="belumlogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Anda belum login !</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Halaman Login Konsumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" class="form-control" id="staticEmail" placeholder="Username" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required="">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Halaman Register Konsumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nama Konsumen</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama_konsumen" class="form-control" id="staticEmail" placeholder="Nama konsumen">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Alamat Konsumen</label>
                            <div class="col-sm-10">
                                <textarea name="alamat_konsumen" id="alamat_konsumen" cols="20" rows="5" class="form-control" placeholder="Alamat konsumen"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">No. WA</label>
                            <div class="col-sm-10">
                                <input type="number" name="no_wa_konsumen" class="form-control" id="staticEmail" placeholder="No. WA">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" class="form-control" id="staticEmail" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editprofil<?= $data_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Alamat Konsumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $cek_konsum = $koneksi->query("SELECT * FROM konsumen where id_konsumen='$data_id'");
                    $data_konsum = $cek_konsum->fetch_assoc();
                    ?>
                    <form method="post" action="alamat.php">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="id_konsumen" value="<?= $data_id; ?>">
                                <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= $data_konsum['nama_konsumen']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?= $data_konsum['alamat']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">No. Wa</label>
                            <div class="col-sm-10">
                                <input type="text" name="wa" class="form-control" placeholder="No. Wa" value="<?= $data_konsum['no_telp']; ?>">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="ubahalamat" class="btn btn-warning">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="checkout<?= $id_checkout; ?>" tabindex="-1" role="dialog" aria-labelledby="checkoutLabel<?= $id_checkout; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutLabel<?= $id_checkout; ?>">Checkout Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                // Ambil data konsumen berdasarkan id_konsumen
                $cek_konsum = $koneksi->query("SELECT * FROM konsumen WHERE id_konsumen='$data_id'");
                $data_konsum = $cek_konsum->fetch_assoc();

                // Ambil data pesanan berdasarkan id_konsumen dan id_pemesanan
                $keranjang_v = $koneksi->query("SELECT SUM(total_bayar) AS total_bayar, id_pemesanan, id_konsumen 
                                                 FROM v_keranjang 
                                                 WHERE id_konsumen='$data_id' 
                                                 AND id_pemesanan='$id_checkout' 
                                                 AND status='0'");
                $data_keranjang_v = $keranjang_v->fetch_assoc();

                // Hitung harga DP (50% dari total bayar)
                $total_bayar = $data_keranjang_v['total_bayar'];
                $harga_dp = $total_bayar * 0.5;
                ?>

                <form method="post" action="checkout.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_konsumen" value="<?= $data_id; ?>">
                    <input type="hidden" name="id_pemesanan" value="<?= $id_checkout; ?>">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?= $data_konsum['nama_konsumen']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control" value="<?= $data_konsum['alamat']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>No. WhatsApp</label>
                        <input type="text" name="wa" class="form-control" value="<?= $data_konsum['no_telp']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Total Harga</label>
                        <input type="text" class="form-control" value="<?= rupiah($total_bayar); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Status Bayar</label>
                        <select name="status_bayar" id="status_bayar" class="form-control">
                            <option disabled selected>Pilih status bayar</option>
                            <option value="0">DP (50%)</option>
                            <option value="2">Lunas</option>
                        </select>
                    </div>

                    <div id="row_dp" class="form-group d-none">
                        <label>Total Bayar DP</label>
                        <input type="text" class="form-control" value="<?= rupiah($harga_dp); ?>" readonly>
                        <input type="hidden" name="nominal_bayar1" value="<?= $harga_dp; ?>">
                    </div>

                    <div id="row_lunas" class="form-group d-none">
                        <label>Total Bayar Lunas</label>
                        <input type="text" class="form-control" value="<?= rupiah($total_bayar); ?>" readonly>
                        <input type="hidden" name="nominal_bayar2" value="<?= $total_bayar; ?>">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Ambil</label>
                        <input type="date" name="tgl_ambil" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Jam Ambil</label>
                        <input type="time" name="jam_ambil" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Bukti Bayar</label>
                        <input type="file" name="bukti" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="checkout" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Tampilkan jumlah bayar sesuai status bayar yang dipilih
    document.getElementById('status_bayar').addEventListener('change', function () {
        var dpField = document.getElementById('row_dp');
        var lunasField = document.getElementById('row_lunas');

        if (this.value == "0") { // Jika pilih DP
            dpField.classList.remove('d-none');
            lunasField.classList.add('d-none');
        } else if (this.value == "2") { // Jika pilih Lunas
            lunasField.classList.remove('d-none');
            dpField.classList.add('d-none');
        }
    });
</script>

    <div class="modal fade" id="detail<?= $idpemesanan; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Foto Produk</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $cek = $koneksi->query("SELECT * from v_keranjang where id_pemesanan='$idpemesanan' and id_konsumen='$data_id' and status=1");
                            while ($keranjang = $cek->fetch_assoc()) {
                            ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><img src="img/<?= $keranjang['foto']; ?>" alt="" width="50px"></td>
                                    <td><?= $keranjang['nama_produk']; ?></td>
                                    <td><?= rupiah($keranjang['harga']); ?></td>
                                    <td><?= $keranjang['quantity_awal']; ?></td>
                                    <td><?= rupiah($keranjang['total_bayar']); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    $keranjang_v = $koneksi->query("SELECT sum(total_bayar) as total_bayar, id_pemesanan FROM v_keranjang where id_konsumen='$data_id' and status='1'");
                    $data_keranjang_v = $keranjang_v->fetch_assoc();
                    $total_bayar = $data_keranjang_v['total_bayar'];
                    ?>
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" colspan="4">TOTAL BAYAR</th>
                                <th scope="col"><?= rupiah($total_bayar); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="detailbarang<?= $idpeminjaman; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Barang Pinjam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Foto barang</th>
                                <th scope="col">Nama barang</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total hari</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $cek = $koneksi->query("SELECT * from v_pinjam where id_peminjaman='$idpeminjaman' and id_konsumen='$data_id' and status between '1' and '2'");
                            while ($keranjang = $cek->fetch_assoc()) {
                            ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><img src="img/<?= $keranjang['foto']; ?>" alt="" width="50px"></td>
                                    <td><?= $keranjang['nama_barang']; ?></td>
                                    <td><?= rupiah($keranjang['harga']); ?></td>
                                    <td><?= $keranjang['quantity']; ?></td>
                                    <td><?= $keranjang['total_hari']; ?></td>
                                    <td><?= rupiah($keranjang['total_bayar']); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    $keranjang_v = $koneksi->query("SELECT sum(total_bayar) as total_bayar, id_peminjaman FROM v_pinjam where id_konsumen='$data_id' and id_peminjaman='$idpeminjaman' and status between '1' and '2'");
                    $data_keranjang_v = $keranjang_v->fetch_assoc();
                    $total_bayar = $data_keranjang_v['total_bayar'];
                    ?>
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" colspan="5">TOTAL BAYAR</th>
                                <th scope="col"><?= rupiah($total_bayar); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
        });
    </script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"> -->
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        $(function() {
            $('#row_dim').hide();
            $('#row_dim2').hide();
            $('#status_bayar').change(function() {
                if ($('#status_bayar').val() == '2') {
                    $('#row_dim').show();
                } else {
                    $('#row_dim').hide();
                }
                if ($('#status_bayar').val() == '0') {
                    $('#row_dim2').show();
                } else {
                    $('#row_dim2').hide();
                }
            });
        });
        $(function() {
            $('#row_dim3').hide();
            $('#row_dim4').hide();
            $('#status_bayar2').change(function() {
                if ($('#status_bayar2').val() == '2') {
                    $('#row_dim4').show();
                } else {
                    $('#row_dim4').hide();
                }
                if ($('#status_bayar2').val() == '0') {
                    $('#row_dim3').show();
                } else {
                    $('#row_dim3').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.plus').click(function() {
                var plus1 = Number($('.plus1').val());
                var plus2 = Number($('.plus2').val());
                var plus3 = Number($('.plus3').val());
                var plus4 = Number($('.plus4').val());

                var getValue = plus1 + plus2;
                var getValue2 = plus3 + plus4;

                $('.plus2').val(getValue);
                $('.plus4').val(getValue2);
            });

            $('.minus').click(function() {
                var plus1 = Number($('.plus1').val());
                var plus2 = Number($('.plus2').val());

                // Pastikan jumlah tidak kurang dari batas minimum (10)
                if (plus2 > plus1) {
                    var getValue = plus2 - plus1;
                    $('.plus2').val(getValue);
                } else {
                    alert("Minimal beli adalah 10!");
                }
            });

            $('.hapus').click(function() {
                $('.plus2').val('');
            });
        });
    </script>
</body>

</html>

<?php
if (isset($_POST['register'])) {
    $nama_konsumen = $_POST['nama_konsumen'];
    $alamat_konsumen = $_POST['alamat_konsumen'];
    $no_wa = $_POST['no_wa_konsumen'];
    $no_wa_custom = substr($no_wa, 1, 1000);
    $no_wa_konsumen = '62' . $no_wa_custom;
    $username = $_POST['username'];
    $password = $_POST['password'];

    $simpan = $koneksi->query("INSERT INTO konsumen (username,password,nama_konsumen,no_telp,alamat) VALUES('$username','$password','$nama_konsumen','$no_wa_konsumen','$alamat_konsumen')");

    if ($simpan) {
        echo '<script>alert("Register berhasil, silahkan login")</script>';
        echo "<meta http-equiv='refresh' content='0; url=$home'>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Pendaftaran Akun Berhasil*\n\nNama : $nama_konsumen\nAlamat : $alamat_konsumen\nNo Wa : $no_wa_konsumen\nUsername : *$username*\nPassword : *$password*\n\nRegards,\nLina Catering ~ Kudus";
        $data = [
            'phone' => $no_wa_konsumen,
            'message' => $pesan,
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://kudus.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    } else {
        echo '<script>alert("Register gagal, silahkan mengulangi register")</script>';
        echo "<meta http-equiv='refresh' content='0; url=$home'>";
    }
}
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek_data = $koneksi->query("SELECT * FROM konsumen where username='$username' and password='$password'");
    $konsumen = $cek_data->fetch_assoc();
    $baris = $cek_data->num_rows;
    if ($cek_data == 1) {
        $_SESSION['ses_username'] = $konsumen['username'];
        $_SESSION['ses_id'] = $konsumen['id_konsumen'];
        echo "<script>alert('Login berhasil')</script>";
        echo "<script>location='$home'</script>";
    } else {
        echo "<script>alert('Login gagal')</script>";
        echo "<script>location='$home'</script>";
    }
}

?>