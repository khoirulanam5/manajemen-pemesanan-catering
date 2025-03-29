 <?php
    include "admin/config/koneksi.php";
    error_reporting(0);
    if (isset($_POST['tambah'])) {
        $x_porsi = $_POST['x_porsi'];
        $jml_beli = $_POST['jml_beli'];
        $id_produk = $_POST['id_produk'];
        $id_resep = $_POST['id_produk'];
        $namaproduk = $_POST['nama_produk'];
        $data_id = $_POST['id_konsumen'];
        $idkategoriproduk = $_POST['id_kategori_produk'];
        $tgl_pesan = date("Y-m-d");
        // cek id keranjang
        $cek_keranjang = $koneksi->query("SELECT max(id_pemesanan) as id_pemesanan, status FROM pemesanan where status between 0 and 6");
        $data_keranjang = $cek_keranjang->fetch_assoc();
        $baris  = $cek_keranjang->num_rows;
        $idkeranjang_db = $data_keranjang['id_pemesanan'];
        $status = $data_keranjang['status'];
        if ($idkeranjang_db == "") {
            $idkeranjang = 1;
        } else {
            $idkeranjang = $idkeranjang_db + 1;
        }

        // cek pemesanan
        $cek_pemesanan = $koneksi->query("SELECT * FROM pemesanan where id_konsumen='$data_id' and status=0");
        $data_pemesanan = $cek_pemesanan->fetch_assoc();
        $baris_data  = $cek_pemesanan->num_rows;

        if ($jml_beli <= "9") {
            echo "<script>alert('Gagal ditambahkan minimal jumlah beli 10')</script>";
            echo "<script>location='index.php?id=$idkategoriproduk'</script>";
        } else {

            if ($baris_data > 0) {
                // cek produk 
                $cek_produk = $koneksi->query("SELECT * from v_keranjang where id_produk='$id_produk' and id_konsumen='$data_id' and status=0");
                $baris_produk = $cek_produk->num_rows;
                $data_produk = $cek_produk->fetch_assoc();
                $quantity = $data_produk['quantity_awal'];
                $total_quantity = $quantity + $jml_beli;
                if ($baris_produk) {
                    $pesan = $koneksi->query("UPDATE detail_pemesanan SET quantity='$total_quantity',x_porsi='$x_porsi',id_resep='$id_resep' where id_produk='$id_produk' and id_konsumen='$data_id' and status=0");
                    if ($pesan) {
                        echo "<script>alert('Jumlah $jml_beli $namaproduk ditambahkan ke keranjang belanja')</script>";
                        echo "<script>location='index.php?halaman=keranjang'</script>";
                    } else {
                        echo "<script>alert('Gagal ditambahkan ke keranjang belanja')</script>";
                        echo "<script>location='?halaman=detailproduk&id=$idkategoriproduk'</script>";
                    }
                } else {
                    // cek pemesanan
                    $cek = $koneksi->query("SELECT * FROM pemesanan where id_konsumen='$data_id' and status=0");
                    $data = $cek->fetch_assoc();
                    $id_keranjang = $data['id_pemesanan'];
                    $baris  = $cek->num_rows;
                    // $tambahproduk = $koneksi->query("INSERT INTO pemesanan (tgl_pesan,id_konsumen,id_pemesanan) values('$tgl_pesan','$data_id','$idkeranjang')");
                    $tambahproduk = $koneksi->query("INSERT INTO detail_pemesanan (id_produk,quantity,x_porsi,id_resep,id_pemesanan,id_konsumen) values ('$id_produk','$jml_beli','$x_porsi','$id_resep','$id_keranjang','$data_id')");
                    if ($tambahproduk) {
                        echo "<script>alert('Berhasil ditambahkan ke keranjang belanja')</script>";
                        echo "<script>location='index.php?halaman=keranjang'</script>";
                    } else {
                        echo "<script>alert('Gagal ditambahkan ke keranjang belanja')</script>";
                        echo "<script>location='?halaman=detailproduk&id=$idkategoriproduk'</script>";
                    }
                    // echo "$id_keranjang";
                }
            } else {
                $tambahproduk = $koneksi->query("INSERT INTO pemesanan (tgl_pesan,id_konsumen,id_pemesanan) values('$tgl_pesan','$data_id','$idkeranjang')");
                $koneksi->query("INSERT INTO detail_pemesanan (id_produk,quantity,x_porsi,id_resep,id_pemesanan,id_konsumen) values ('$id_produk','$jml_beli','$x_porsi','$id_resep','$idkeranjang','$data_id')");
                if ($tambahproduk) {
                    echo "<script>alert('Berhasil ditambahkan ke keranjang belanja')</script>";
                    echo "<script>location='index.php?halaman=keranjang'</script>";
                } else {
                    echo "<script>alert('Gagal ditambahkan ke keranjang belanja')</script>";
                    echo "<script>location='?halaman=detailproduk&id=$idkategoriproduk'</script>";
                }
            }
        }
    }
    ?>