<?php
//Mulai Sesion
session_start();
if (isset($_SESSION["ses_username"]) == "") {
    header("location: login.php");
} else {
    $data_id = $_SESSION["ses_id"];
    $data_nama = $_SESSION["ses_nama"];
    $data_user = $_SESSION["ses_username"];
    $data_level = $_SESSION["ses_level"];
}
include "config/koneksi.php";

$produk = mysqli_query($koneksi, "SELECT nama_produk from v_keranjang GROUP by id_produk");
$jml_produk = mysqli_query($koneksi, "SELECT count(id_produk) as jml_produk from v_keranjang GROUP by id_produk");

$halaman = isset($_GET['halaman']) ? $_GET['halaman'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lina Catering - Dashboard</title>
    <link rel= "icon" href="../img/DM.png">
    <!-- Custom fonts for this template-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

</head>

<body id="page-top" class="hold-transition sidebar-mini">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-warning sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <img src="../img/DM.png" alt="" class="brand-image" style="opacity: .8" width="40px">
                <span class="brand-text"><small><b>Lina Catering</small></span></b>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- level -->
            <?php
            if ($data_level == "Pemilik") {
            ?>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item <?= ($halaman == 'home') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'laporan') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=laporan" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <span>Kelola Laporan</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'user') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=user" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <span>Kelola User</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'konsumen') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=konsumen" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <span>Kelola Konsumen</span>
                    </a>
                </li>
            <?php
            } elseif ($data_level == "Kasir") {
            ?>
                <li class="nav-item <?= ($halaman == 'home') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'pesanan') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=pesanan" class="nav-link">
                        <i class="nav-icon fas fa-utensils"></i>
                        <span>Kelola Pesanan Masuk</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'kategori-produk') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=kategori-produk" class="nav-link">
                        <i class="nav-icon fas fa-utensils"></i>
                        <span>Kelola Kategori Produk</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'produk') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=produk" class="nav-link">
                        <i class="nav-icon fas fa-utensils"></i>
                        <span>Kelola Produk</span>
                    </a>
                </li>
            <?php
            } elseif ($data_level == "Dapur") {
            ?>
                <li class="nav-item <?= ($halaman == 'home') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'estimasi') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=estimasi" class="nav-link">
                        <i class="nav-icon fas fa-utensils"></i>
                        <span>Total Pemesanan</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'bahan') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=bahan" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <span>Bahan</span>
                    </a>
                </li>
                <li class="nav-item <?= ($halaman == 'resep') ? 'active' : ''; ?>">
                    <a href="index.php?halaman=resep" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <span>Resep</span>
                    </a>
                </li>         
            <?php
            }
            ?>
            <li class="nav-item">
                <a onclick="return confirm('Apakah anda yakin akan keluar ?')" href="logout.php" class="nav-link">
                    <i class="nav-icon fas fa-arrow-circle-right"></i>
                    Logout
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $data_level; ?></span>
                                <i class="fas fa-user-circle fa-lg text-gray-600"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="index.php?halaman=profile&id=<?php echo $_SESSION['ses_id']; ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" onclick="return confirm('Apakah anda yakin akan keluar ?')" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->


                    <!-- Content Row -->
                    <div class="row">




                        <!-- End of Footer -->

                    </div>
                    <!-- End of Content Wrapper -->
                    <!-- /. NAV SIDE  -->
                    <div id="page-wrapper">
                        <div id="page-inner">
                            <?php
                            if (isset($_GET['halaman'])) {
                                if ($_GET['halaman'] == "produk") {
                                    include 'produk.php';
                                } else if ($_GET['halaman'] == "kategori-produk") {
                                    include 'kategori_produk.php';
                                } elseif ($_GET['halaman'] == "pembelianbahan") {
                                    include 'pembelianbahan.php';
                                } elseif ($_GET['halaman'] == "user") {
                                    include 'user.php';
                                } elseif ($_GET['halaman'] == "tambahuser") {
                                    include 'tambahuser.php';
                                } elseif ($_GET['halaman'] == "ubahuser") {
                                    include 'ubahuser.php';
                                } elseif ($_GET['halaman'] == "tambahproduk") {
                                    include 'tambahproduk.php';
                                } elseif ($_GET['halaman'] == "tambahkategoriproduk") {
                                    include 'tambah_kategori_produk.php';
                                } elseif ($_GET['halaman'] == "ubahproduk") {
                                    include 'ubahproduk.php';
                                } elseif ($_GET['halaman'] == "ubahkategoriproduk") {
                                    include 'ubah_kategori_produk.php';
                                } elseif ($_GET['halaman'] == "hapusproduk") {
                                    include 'hapusproduk.php';
                                } elseif ($_GET['halaman'] == "bahan") {
                                    include 'bahan.php';
                                } elseif ($_GET['halaman'] == "tambahbahan") {
                                    include 'tambahbahan.php';
                                } elseif ($_GET['halaman'] == "ubahbahan") {
                                    include 'ubahbahan.php';
                                } elseif ($_GET['halaman'] == "hapusbahan") {
                                    include 'hapusbahan.php';
                                } elseif ($_GET['halaman'] == "barang") {
                                    include 'barang.php';
                                } elseif ($_GET['halaman'] == "ubahbarang") {
                                    include 'ubahbarang.php';
                                } elseif ($_GET['halaman'] == "tambahbarang") {
                                    include 'tambahbarang.php';
                                } elseif ($_GET['halaman'] == "laporan") {
                                    include 'laporan.php';
                                } elseif ($_GET['halaman'] == "peminjaman") {
                                    include 'peminjaman.php';
                                } elseif ($_GET['halaman'] == "pesanan") {
                                    include 'pesanan.php';
                                } elseif ($_GET['halaman'] == "logout") {
                                    include 'logout.php';
                                } elseif ($_GET['halaman'] == "detailpesanan") {
                                    include 'detail_pesanan.php';
                                } elseif ($_GET['halaman'] == "detailpinjam") {
                                    include 'detail_pinjam.php';
                                } elseif ($_GET['halaman'] == "laporanpesanan") {
                                    include 'laporan_pesanan.php';
                                } elseif ($_GET['halaman'] == "laporanpeminjaman") {
                                    include 'laporan_peminjaman.php';
                                } elseif ($_GET['halaman'] == "konsumen") {
                                    include 'konsumen.php';
                                } elseif ($_GET['halaman'] == "tambahkonsumen") {
                                    include 'tambahkonsumen.php';
                                } elseif ($_GET['halaman'] == "ubahkonsumen") {
                                    include 'ubahkonsumen.php';
                                } elseif ($_GET['halaman'] == "laporan") {
                                    include 'laporan.php';
                                } elseif ($_GET['halaman'] == "estimasi") {
                                    include 'estimasi.php';
                                } elseif ($_GET['halaman'] == "estimasibahan") {
                                    include 'estimasibahan.php';
                                } elseif ($_GET['halaman'] == "resep") {
                                    include 'resep.php';
                                } elseif ($_GET['halaman'] == "tambahresep") {
                                    include 'tambahresep.php';
                                } elseif ($_GET['halaman'] == "profile") {
                                    include 'profile.php';
                                }
                            } else
                                include "dashboard.php";
                            ?>
                        </div>
                    </div>
                    <!-- End of Page Wrapper -->

                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>


                    <!-- Bootstrap core JavaScript-->
                    <script src="vendor/jquery/jquery.min.js"></script>
                    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                    <!-- Core plugin JavaScript-->
                    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

                    <!-- Custom scripts for all pages-->
                    <script src="js/sb-admin-2.min.js"></script>

                    <!-- Page level plugins -->
                    <script src="vendor/chart.js/Chart.min.js"></script>

                    <!-- Page level custom scripts -->
                    <script src="js/demo/chart-area-demo.js"></script>
                    <script src="js/demo/chart-pie-demo.js"></script>
                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable();
                        });
                    </script>
                    <script src="https://code.highcharts.com/highcharts.js"></script>
                    <script src="https://code.highcharts.com/modules/data.js"></script>
                    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
                    <script src="https://code.highcharts.com/modules/exporting.js"></script>
                    <script src="https://code.highcharts.com/modules/export-data.js"></script>
                    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

                    <script>
                        // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

                        // Create the chart
                        Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                align: 'left',
                                text: 'Browser market shares. January, 2022'
                            },
                            subtitle: {
                                align: 'left',
                                text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                            },
                            accessibility: {
                                announceNewData: {
                                    enabled: true
                                }
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: {
                                    text: 'Total percent market share'
                                }

                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.y:.1f}%'
                                    }
                                }
                            },

                            tooltip: {
                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                            },

                            series: [{
                                name: 'Browsers',
                                colorByPoint: true,
                                data: [{
                                        name: 'Chrome',
                                        y: 63.06,
                                        drilldown: 'Chrome'
                                    },
                                    {
                                        name: 'Safari',
                                        y: 19.84,
                                        drilldown: 'Safari'
                                    },
                                    {
                                        name: 'Firefox',
                                        y: 4.18,
                                        drilldown: 'Firefox'
                                    },
                                    {
                                        name: 'Edge',
                                        y: 4.12,
                                        drilldown: 'Edge'
                                    },
                                    {
                                        name: 'Opera',
                                        y: 2.33,
                                        drilldown: 'Opera'
                                    },
                                    {
                                        name: 'Internet Explorer',
                                        y: 0.45,
                                        drilldown: 'Internet Explorer'
                                    },
                                    {
                                        name: 'Other',
                                        y: 1.582,
                                        drilldown: null
                                    }
                                ]
                            }],
                            drilldown: {
                                breadcrumbs: {
                                    position: {
                                        align: 'right'
                                    }
                                },
                                series: [{
                                        name: 'Chrome',
                                        id: 'Chrome',
                                        data: [
                                            [
                                                'v65.0',
                                                0.1
                                            ],
                                            [
                                                'v64.0',
                                                1.3
                                            ],
                                            [
                                                'v63.0',
                                                53.02
                                            ],
                                            [
                                                'v62.0',
                                                1.4
                                            ],
                                            [
                                                'v61.0',
                                                0.88
                                            ],
                                            [
                                                'v60.0',
                                                0.56
                                            ],
                                            [
                                                'v59.0',
                                                0.45
                                            ],
                                            [
                                                'v58.0',
                                                0.49
                                            ],
                                            [
                                                'v57.0',
                                                0.32
                                            ],
                                            [
                                                'v56.0',
                                                0.29
                                            ],
                                            [
                                                'v55.0',
                                                0.79
                                            ],
                                            [
                                                'v54.0',
                                                0.18
                                            ],
                                            [
                                                'v51.0',
                                                0.13
                                            ],
                                            [
                                                'v49.0',
                                                2.16
                                            ],
                                            [
                                                'v48.0',
                                                0.13
                                            ],
                                            [
                                                'v47.0',
                                                0.11
                                            ],
                                            [
                                                'v43.0',
                                                0.17
                                            ],
                                            [
                                                'v29.0',
                                                0.26
                                            ]
                                        ]
                                    },
                                    {
                                        name: 'Firefox',
                                        id: 'Firefox',
                                        data: [
                                            [
                                                'v58.0',
                                                1.02
                                            ],
                                            [
                                                'v57.0',
                                                7.36
                                            ],
                                            [
                                                'v56.0',
                                                0.35
                                            ],
                                            [
                                                'v55.0',
                                                0.11
                                            ],
                                            [
                                                'v54.0',
                                                0.1
                                            ],
                                            [
                                                'v52.0',
                                                0.95
                                            ],
                                            [
                                                'v51.0',
                                                0.15
                                            ],
                                            [
                                                'v50.0',
                                                0.1
                                            ],
                                            [
                                                'v48.0',
                                                0.31
                                            ],
                                            [
                                                'v47.0',
                                                0.12
                                            ]
                                        ]
                                    },
                                    {
                                        name: 'Internet Explorer',
                                        id: 'Internet Explorer',
                                        data: [
                                            [
                                                'v11.0',
                                                6.2
                                            ],
                                            [
                                                'v10.0',
                                                0.29
                                            ],
                                            [
                                                'v9.0',
                                                0.27
                                            ],
                                            [
                                                'v8.0',
                                                0.47
                                            ]
                                        ]
                                    },
                                    {
                                        name: 'Safari',
                                        id: 'Safari',
                                        data: [
                                            [
                                                'v11.0',
                                                3.39
                                            ],
                                            [
                                                'v10.1',
                                                0.96
                                            ],
                                            [
                                                'v10.0',
                                                0.36
                                            ],
                                            [
                                                'v9.1',
                                                0.54
                                            ],
                                            [
                                                'v9.0',
                                                0.13
                                            ],
                                            [
                                                'v5.1',
                                                0.2
                                            ]
                                        ]
                                    },
                                    {
                                        name: 'Edge',
                                        id: 'Edge',
                                        data: [
                                            [
                                                'v16',
                                                2.6
                                            ],
                                            [
                                                'v15',
                                                0.92
                                            ],
                                            [
                                                'v14',
                                                0.4
                                            ],
                                            [
                                                'v13',
                                                0.1
                                            ]
                                        ]
                                    },
                                    {
                                        name: 'Opera',
                                        id: 'Opera',
                                        data: [
                                            [
                                                'v50.0',
                                                0.96
                                            ],
                                            [
                                                'v49.0',
                                                0.82
                                            ],
                                            [
                                                'v12.1',
                                                0.14
                                            ]
                                        ]
                                    }
                                ]
                            }
                        });
                    </script>
                    <script>
                        var ctx = document.getElementById("myChart").getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                // labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Agust', 'Sept', 'Oct', 'Nov', 'Dec'],
                                labels: [<?php while ($b = mysqli_fetch_array($produk)) {
                                                echo '"' . strtoupper($b['nama_produk']) . '",';
                                            } ?>],
                                datasets: [{
                                    label: 'Jumlah Persentase Pesanan',
                                    backgroundColor: ['rgb(211, 84, 0)', 'rgb(52, 152, 219)', 'rgb(241, 196, 15)', 'rgb(155, 89, 182)', 'rgb(22, 160, 133)'],
                                    data: [
                                        <?php while ($p = mysqli_fetch_array($jml_produk)) {
                                            echo '"' . $p['jml_produk'] . '",';
                                        } ?>
                                    ]
                                }]
                            },
                            options: {
                                scales: {

                                    yAxes: [{
                                        ticks: {

                                            min: 0,
                                            max: 100,
                                            callback: function(value) {
                                                return value + "%"
                                            }
                                        },
                                        scaleLabel: {
                                            display: true,
                                            labelString: "Percentage"
                                        }
                                    }]
                                }
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(tooltipItems, data) {
                                        if (percent)
                                            return addCommas(tooltipItems.xLabel) + "%";
                                        else
                                            return addCommas(tooltipItems.xLabel);
                                    }
                                }
                            },
                        });
                    </script>
</body>

</html>