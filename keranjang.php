<section class="py-5">
     <div class="container px-4 px-lg-5 my-5">
         <div class="row">
             <div class="col-sm-6">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>ALAMAT KONSUMEN</b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <table class="table table-striped">
                                 <thead>
                                     <tr>
                                         <th scope="col">Nama</th>
                                         <th scope="col">Alamat</th>
                                         <th scope="col">No. WA</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $cek_konsumen = $koneksi->query("SELECT * FROM konsumen where id_konsumen='$data_id'");
                                        $data_konsumen = $cek_konsumen->fetch_assoc();
                                        ?>
                                     <tr>
                                         <td><?= $data_konsumen['nama_konsumen']; ?></td>
                                         <td><?= $data_konsumen['alamat']; ?></td>
                                         <td><?= $data_konsumen['no_telp']; ?></td>
                                     </tr>
                                 </tbody>
                             </table>
                         </div>
                         <div class="row">
                             <button type="button" class="btn btn-md btn-warning" data-toggle="modal" data-target="#editprofil<?= $data_id; ?>">Edit</button>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-sm-6">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>KERANJANG</b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <?php
                                $cek_belanja = $koneksi->query("SELECT * FROM v_keranjang where id_konsumen='$data_id' and status='0'");
                                $belanja = $cek_belanja->num_rows;
                                if ($belanja > 0) {
                                ?>
                                 <table class="table">
                                     <thead class="thead-dark">
                                         <tr>
                                             <th scope="col">No.</th>
                                             <th scope="col">Foto produk</th>
                                             <th scope="col">Nama produk</th>
                                             <th scope="col">Quantity</th>
                                             <th scope="col">Harga</th>
                                             <th scope="col">Total Harga</th>
                                             <th scope="col">Aksi</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                            $no = 1;
                                            $keranjang_v = $koneksi->query("SELECT * FROM v_keranjang where id_konsumen='$data_id' and status='0'");
                                            while ($data_keranjang_v = $keranjang_v->fetch_assoc()) {
                                            ?>
                                             <tr>
                                                 <th scope="row"><?= $no++; ?></th>
                                                 <td><img src="img/<?= $data_keranjang_v['foto']; ?>" width="50px;" alt=""></td>
                                                 <td><?= $data_keranjang_v['nama_produk']; ?></td>
                                                 <td><?= $data_keranjang_v['quantity_awal']; ?></td>
                                                 <td><?= rupiah($data_keranjang_v['harga']); ?></td>
                                                 <td><?= rupiah($data_keranjang_v['total_bayar']); ?></td>
                                                 <td>
                                                     <a href="?halaman=keranjang&idbeli=<?= $data_keranjang_v['id_keranjang']; ?>" class="btn btn-danger btn-sm" onclick="return(confirm('anda yakin hapus data ini ?'))">hapus</a>
                                                 </td>
                                             </tr>
                                         <?php
                                            }
                                            ?>
                                     </tbody>
                                 </table>

                                 <?php
                                    $keranjang_v = $koneksi->query("SELECT sum(total_bayar) as total_bayar, id_pemesanan FROM v_keranjang where id_konsumen='$data_id' and status='0'");
                                    $data_keranjang_v = $keranjang_v->fetch_assoc();
                                    $total_bayar = $data_keranjang_v['total_bayar'];
                                    $id_checkout = $data_keranjang_v['id_pemesanan'];
                                    ?>


                                 <table class="table">
                                     <thead class="thead-light">
                                         <tr>
                                             <th scope="col" colspan="6">TOTAL BAYAR</th>
                                             <th scope="col"><?= rupiah($total_bayar); ?></th>
                                         </tr>
                                     </thead>
                                 </table>
                         </div>
                         <div class="row">
                             <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#checkout<?= $id_checkout; ?>">Checkout</button>
                         </div>
                     <?php
                                } else {
                        ?>
                         <table class="table">
                             <thead class="thead-dark">
                                 <tr>
                                     <th scope="col">No.</th>
                                     <th scope="col">Nama produk</th>
                                     <th scope="col">Quantity</th>
                                     <th scope="col">Harga</th>
                                     <th scope="col">Total Harga</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                     <th colspan="5">
                                         <h1>ANDA BELUM MEMESAN PRODUK !</h1>
                                     </th>
                                 </tr>
                             </tbody>
                         </table>
                         </table>
                     <?php
                                }
                        ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>


 <?php
    if (isset($_GET['idbeli'])) {
        $idbeli = $_GET['idbeli'];
        $hapus = $koneksi->query("delete from detail_pemesanan where id_keranjang='$idbeli'");
        echo "<script>alert('data telah dihapus')</script>";
        echo "<script>location='index.php?halaman=keranjang'</script>";
    } elseif (isset($_GET['idbeli'])) {
        $idbeli = $_GET['idbeli'];
        $hapus = $koneksi->query("delete from pemesanan where id_pemesanan='$idbeli'");
        $hapus = $koneksi->query("delete from detail_pemesanan where id_pemesanan='$idbeli'");
        echo "<script>alert('data telah dihapus')</script>";
        echo "<script>location='index.php?halaman=keranjang'</script>";
    }
    if (isset($_GET['idpinjam'])) {
        $idpinjam = $_GET['idpinjam'];
        // cek jml brg
        $cek_brg = $koneksi->query("select * from v_pinjam where id='$idpinjam'");
        $row_cek_brg = $cek_brg->fetch_assoc();
        $jumlah_brg = $row_cek_brg['jumlah_brg'];
        $qty = $row_cek_brg['quantity'];
        $jml = $jumlah_brg + $qty;
        $idbarang = $row_cek_brg['id_barang'];
        $id_peminjaman = $row_cek_brg['id_peminjaman'];
        // update brg
        $hapus = $koneksi->query("update barang set jumlah_brg='$jml' where id_barang='$idbarang'");
        // $hapus = $koneksi->query("delete from peminjaman where id_peminjaman='$id_peminjaman'");
        $hapus = $koneksi->query("delete from detail_peminjaman where id='$idpinjam'");
        echo "<script>alert('data telah dihapus')</script>";
        echo "<script>location='index.php?halaman=keranjang'</script>";
    } elseif (isset($_GET['idbeli'])) {
        $idbeli = $_GET['idbeli'];
        $hapus = $koneksi->query("delete from pemesanan where id_pemesanan='$idbeli'");
        $hapus = $koneksi->query("delete from detail_pemesanan where id_pemesanan='$idbeli'");
        echo "<script>alert('data telah dihapus')</script>";
        echo "<script>location='index.php?halaman=keranjang'</script>";
    }
    ?>