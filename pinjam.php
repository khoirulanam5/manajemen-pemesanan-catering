 <?php
    include "admin/config/koneksi.php";
    error_reporting(0);
    if (isset($_POST['pinjam'])) {
        $jml_pinjam = $_POST['jml_pinjam'];
        $id_barang = $_POST['id_barang'];
        $namabarang = $_POST['nama_barang'];
        $data_id = $_POST['id_konsumen'];
        $tgl_pinjam = date("Y-m-d H:i:s");
        $tgl_kembali = $_POST['tgl_kembali'];
        $total_hari = $_POST['total_hari'];
        // cek id pinjam
        $cek_pinjam = $koneksi->query("SELECT max(id_peminjaman) as id_peminjaman, status FROM peminjaman where status between '0' and '4'");
        $data_pinjam = $cek_pinjam->fetch_assoc();
        $baris  = $cek_pinjam->num_rows;
        $idpinjam_db = $data_pinjam['id_peminjaman'];
        if ($idpinjam_db == "") {
            $idpinjam = 1;
        } else {
            $idpinjam = $idpinjam_db + 1;
        }
        // cek barang
        $cek_brg = $koneksi->query("SELECT * FROM barang where id_barang='$id_barang'");
        $row_cek_brg = $cek_brg->fetch_assoc();
        $jumlah_brg = $row_cek_brg['jumlah_brg'];
        $jml_brg =   $jumlah_brg - $jml_pinjam;

        // cek peminjaman
        $cek_peminjaman = $koneksi->query("SELECT * FROM peminjaman where id_konsumen='$data_id' and status='0'");
        $data_peminjaman = $cek_peminjaman->fetch_assoc();
        $baris_data  = $cek_peminjaman->num_rows;

        if ($jumlah_brg == "0") {
            echo "<script>alert('Stok barang habis')</script>";
            echo "<script>location='index.php?halaman=pinjambarang'</script>";
        } elseif ($jml_pinjam > $jumlah_brg) {
            echo "<script>alert('Jumlah pinjam melebihi stock barang')</script>";
            echo "<script>location='index.php?halaman=pinjambarang'</script>";
        } else {

            if ($baris_data > 0) {
                // cek barang 
                $cek_barang = $koneksi->query("SELECT * from v_pinjam where id_barang='$id_barang' and id_konsumen='$data_id' and status='0'");
                $baris_barang = $cek_barang->num_rows;
                $data_barang = $cek_barang->fetch_assoc();
                $quantity = $data_barang['quantity_awal'];
                $id_pinjam1 = $data_barang['id_peminjaman'];
                $total_quantity = $quantity + $jml_pinjam;
                if ($baris_barang) {

                    // update jml brg
                    $pesan = $koneksi->query("UPDATE barang set jumlah_brg='$jml_brg' where id_barang='$id_barang'");
                    $pesan = $koneksi->query("UPDATE detail_peminjaman SET quantity='$total_quantity' where id_barang='$id_barang' and id_konsumen='$data_id' and status='0'");
                    $pesan = $koneksi->query("UPDATE peminjaman SET tgl_kembali='$tgl_kembali', total_hari='$total_hari' where id_peminjaman='$id_pinjam1' and id_konsumen='$data_id' and status='0'");
                    if ($pesan) {
                        echo "<script>alert('Jumlah $jml_pinjam $namabarang ditambahkan ke pinjam belanja')</script>";
                        echo "<script>location='index.php?halaman=pinjam'</script>";
                    } else {
                        echo "<script>alert('Gagal ditambahkan ke pinjam belanja')</script>";
                        echo "<script>location='?halaman=pinjambarang'</script>";
                    }
                } else {
                    // cek peminjaman
                    $cek = $koneksi->query("SELECT * FROM peminjaman where id_konsumen='$data_id' and status='0'");
                    $data = $cek->fetch_assoc();
                    $id_pinjam = $data['id_peminjaman'];
                    $baris  = $cek->num_rows;
                    // update jml brg
                    $tambahbarang = $koneksi->query("UPDATE barang set jumlah_brg='$jml_brg' where id_barang='$id_barang'");
                    $tambahbarang = $koneksi->query("INSERT INTO detail_peminjaman (id_barang,quantity,id_peminjaman,id_konsumen) values ('$id_barang','$jml_pinjam','$id_pinjam','$data_id')");
                    if ($tambahbarang) {
                        echo "<script>alert('Berhasil ditambahkan ke pinjam belanja')</script>";
                        echo "<script>location='index.php?halaman=keranjang'</script>";
                    } else {
                        echo "<script>alert('Gagal ditambahkan ke pinjam belanja')</script>";
                        echo "<script>location='?halaman=pinjambarang'</script>";
                    }
                    // echo "$id_pinjam";
                }
            } else {
                // update jml brg
                $tambahbarang = $koneksi->query("UPDATE barang set jumlah_brg='$jml_brg' where id_barang='$id_barang'");
                $tambahbarang = $koneksi->query("INSERT INTO peminjaman (tgl_pinjam,tgl_kembali,total_hari,id_konsumen,id_peminjaman) values('$tgl_pinjam','$tgl_kembali','$total_hari','$data_id','$idpinjam')");
                $koneksi->query("INSERT INTO detail_peminjaman (id_barang,quantity,id_peminjaman,id_konsumen) values ('$id_barang','$jml_pinjam','$idpinjam','$data_id')");
                if ($tambahbarang) {
                    echo "<script>alert('Berhasil ditambahkan ke pinjam belanja')</script>";
                    echo "<script>location='index.php?halaman=keranjang'</script>";
                } else {
                    echo "<script>alert('Gagal ditambahkan ke pinjam belanja')</script>";
                    echo "<script>location='?halaman=pinjambarang'</script>";
                }
            }
        }
    }
    ?>