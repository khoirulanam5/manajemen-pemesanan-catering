 <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
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
                                 <a class="nav-link active" href="javascript.void(0);"><b>DETAIL PRODUK <?= $id; ?></b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <table class="table">
                                 <thead class="thead-dark">
                                     <tr>
                                         <th scope="col">No.</th>
                                         <th scope="col">Poto Produk</th>
                                         <th scope="col">Nama Produk</th>
                                         <th scope="col">Harga</th>
                                         <th scope="col">Quantity</th>
                                         <th scope="col">Total Harga</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $no = 1;
                                        $cek = $koneksi->query("SELECT * from v_keranjang where id_pemesanan='$id' and id_konsumen='$data_id' and status between '1' and '3'");
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
                                $keranjang_v = $koneksi->query("SELECT sum(total_bayar) as total_bayar, id_pemesanan FROM v_keranjang where id_pemesanan='$id' and id_konsumen='$data_id' and status between '1' and '3'");
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
                     </div>
                 </div>
             </div>
         </div> <br><br>
         <div class="row">
             <div class="col-sm-12">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>RINCIAN PEMBAYARAN</b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <table class="table">
                                 <thead class="thead-dark">
                                     <tr>
                                         <th scope="col">No.</th>
                                         <th scope="col">Tgl Bayar</th>
                                         <th scope="col">Bukti Pembayaran</th>
                                         <th scope="col">Status Bayar</th>
                                         <th scope="col">Nominal Bayar</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $no = 1;
                                        $cek = $koneksi->query("SELECT * from v_pembayaran where id_pemesanan='$id' and id_konsumen='$data_id' and status between '1' and '3'");
                                        while ($keranjang = $cek->fetch_assoc()) {
                                            $status_bayar = $keranjang['status_bayar'];
                                            $tgl_bayar = $keranjang['tgl_bayar'];
                                            if ($status_bayar == "0" || $status_bayar == "1") {
                                                $status_bayar = "DP";
                                            } else {
                                                $status_bayar = "Lunas";
                                            }
                                        ?>
                                         <tr>
                                             <th scope="row"><?= $no++; ?></th>
                                             <td><?= $tgl_bayar; ?></td>
                                             <td><img src="bukti/<?= $keranjang['bukti_pembayaran']; ?>" alt="" width="50px"></td>
                                             <td><?= $status_bayar; ?></td>
                                             <td><?= rupiah($keranjang['total']); ?></td>
                                         </tr>
                                     <?php
                                        }
                                        ?>
                                 </tbody>
                             </table>

                             <?php
                                $keranjang_v = $koneksi->query("SELECT sum(total) as total_bayar, id_pemesanan FROM v_pembayaran where id_pemesanan='$id' and id_konsumen='$data_id' and status between '1' and '3'");
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
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>