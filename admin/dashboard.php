<?php
$cek = mysqli_query($koneksi, "SELECT * from pemesanan where status='1'");
$pesanan_masuk = mysqli_num_rows($cek);
$cek_laporan = mysqli_query($koneksi, "SELECT * from pemesanan where status=6");
$laporan_pemesanan = mysqli_num_rows($cek_laporan);
$cek_saldo = mysqli_query($koneksi, "SELECT sum(total) as total_bayar from v_pembayaran where status between 1 and 5");
$saldo_cek = mysqli_fetch_array($cek_saldo);
$saldo_pesanan = $saldo_cek['total_bayar'];
$cek_saldo_pinjam = mysqli_query($koneksi, "SELECT sum(total) as total_bayar from v_pembayaran_pinjam where status='3'");
$saldo_cek_pinjam = mysqli_fetch_array($cek_saldo_pinjam);
$saldo_pinjam = $saldo_cek_pinjam['total_bayar'];
$saldo = $saldo_pesanan + $saldo_pinjam;

$cek_pinjam = mysqli_query($koneksi, "SELECT * from peminjaman where status='1'");
$pinjam = mysqli_num_rows($cek_pinjam);
$laporan_peminjaman = mysqli_query($koneksi, "SELECT * from peminjaman where status='4'");
$jml_pinjam = mysqli_num_rows($laporan_peminjaman);

$cek_user = mysqli_query($koneksi, "SELECT * from user");
$jml_user = mysqli_num_rows($cek_user);

$cek_konsumen = mysqli_query($koneksi, "SELECT * from konsumen");
$jml_konsumen = mysqli_num_rows($cek_konsumen);

$cekdenda = mysqli_query($koneksi, "SELECT sum(jumlah_denda) as total_denda FROM denda");
$rowdenda = mysqli_fetch_array($cekdenda);
$saldodenda = $rowdenda['total_denda'];

$cek2 = mysqli_query($koneksi, "SELECT * from pemesanan where status between 2 and 3");
$pesanan_masuk2 = mysqli_num_rows($cek2);

$cekprod = mysqli_query($koneksi, "SELECT * FROM produk");
$cek_produk = mysqli_num_rows($cekprod);
?>
<?php
if ($data_level == "Kasir") {
?>
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                PESANAN MASUK</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_masuk; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                SALDO</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= rupiah($saldo); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                KARYAWAN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_user; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                KONSUMEN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_konsumen; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} elseif ($data_level == "Pemilik") {
?>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                PRODUK</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $cek_produk; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                SALDO</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= rupiah($saldo); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                KARYAWAN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_user; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                KONSUMEN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_konsumen; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php
} elseif ($data_level == "Dapur") {
?>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                PESANAN MASUK</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_masuk2; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>