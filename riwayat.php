<section class="py-5">
     <div class="container px-4 px-lg-5 my-5">
         <div class="row">
             <div class="col-sm-12">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>RIWAYAT PEMESANAN</b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <table id="example" class="table table-striped" style="width:100%">
                                 <thead>
                                     <tr>
                                         <th>ID Pemesanan</th>
                                         <th>Nama</th>
                                         <th>No. wa</th>
                                         <th>Alamat</th>
                                         <th>Tanggal Pesan</th>
                                         <th>Tanggal Ambil</th>
                                         <th>Bukti</th>
                                         <th>Nominal Bayar</th>
                                         <th>Status</th>
                                         <th>Aksi</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $cek = $koneksi->query("SELECT * FROM v_pembayaran WHERE id_konsumen = '$data_id' AND status IN (3, 4, 5) GROUP BY id_pemesanan ORDER BY id_pemesanan DESC");
                                        while ($data = $cek->fetch_assoc()) {
                                            $nama_konsumen = $data['nama_konsumen'];
                                            $tgl_pesan = date("d-m-Y", strtotime($data['tgl_pesan']));
                                            $tgl_ambil = date("d-m-Y", strtotime($data['tgl_ambil']));
                                            $alamat = $data['alamat'];
                                            $idpemesanan = $data['id_pemesanan'];
                                            $no_wa = $data['no_telp'];
                                            $idprofil = $data['id_konsumen'];
                                            $status = $data['status'];
                                            $bukti = $data['bukti_pembayaran'];
                                            $idpemesanan = $data['id_pemesanan'];
                                            $total = $data['total'];
                                        ?>
                                         <tr>
                                             <td><?= $idpemesanan; ?></td>
                                             <td><?= $nama_konsumen; ?></td>
                                             <td><?= $no_wa; ?></td>
                                             <td><?= $alamat; ?></td>
                                             <td><?= $tgl_pesan; ?></td>
                                             <td><?= $tgl_ambil; ?></td>
                                             <td><img src="bukti/<?= $bukti; ?>" width="200px" alt=""></td>
                                             <td><?= rupiah($total); ?></td>
                                             <td>
                                                <?php if ($status == 5): ?>
                                                    <span class="badge badge-success">Pesanan Sudah diambil</span>
                                                <?php elseif($status == 4): ?>
                                                    <span class="badge badge-info">Pesanan Selesai (silahkan ambil pesanan)</span>
                                                <?php elseif($status == 3): ?>
                                                    <span class="badge badge-warning">Pesanan Sedang dibuat</span>
                                                <?php endif; ?>
                                            </td>
                                             <td>
                                                 <a href="admin/cetak_nota.php?id=<?= $idpemesanan; ?>" class="btn-primary btn">cetak nota</a>
                                             </td>
                                         </tr>
                                     <?php
                                        }
                                        ?>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>