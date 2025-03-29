<section class="py-5">
     <div class="container px-4 px-lg-5 my-5">
         <div class="row">
             <div class="col-sm-12">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>STATUS PEMESANAN</b></a>
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
                                         <th>Jam Ambil</th>
                                         <th>Bukti</th>
                                         <th>Total Bayar</th>
                                         <th>Status</th>
                                         <th>Aksi</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $cek = $koneksi->query("SELECT * FROM v_pembayaran where id_konsumen = '$data_id' and status between '0' and '2' group by id_pemesanan order by id_pembayaran desc");
                                        while ($data = $cek->fetch_assoc()) {
                                            $nama_konsumen = $data['nama_konsumen'];
                                            $tgl_pesan = date("d-m-Y", strtotime($data['tgl_pesan']));
                                            $tgl_ambil = date("d-m-Y", strtotime($data['tgl_ambil']));
                                            $jam_ambil = date("H:i", strtotime($data['jam_ambil']));
                                            $alamat = $data['alamat'];
                                            $idpemesanan = $data['id_pemesanan'];
                                            $no_wa = $data['no_telp'];
                                            $idprofil = $data['id_konsumen'];
                                            $status = $data['status'];
                                            $status_bayar3 = $data['status_bayar'];
                                            $status_bayar2 = $data['status_bayar'];
                                            $status = $data['status'];
                                            $bukti = $data['bukti_pembayaran'];
                                            $total = $data['total'];
                                        ?>
                                         <tr>
                                             <td><?= $idpemesanan; ?></td>
                                             <td><?= $nama_konsumen; ?></td>
                                             <td><?= $no_wa; ?></td>
                                             <td><?= $alamat; ?></td>
                                             <td><?= $tgl_pesan; ?></td>
                                             <td><?= $tgl_ambil; ?></td>
                                             <td><?= $jam_ambil; ?></td>
                                             <td><img src="bukti/<?= $bukti; ?>" width="200px" alt=""></td>
                                             <td><?= rupiah($total); ?></td>
                                             <td>
                                                 <?php
                                                    if ($status <= "1") {
                                                    ?>
                                                     <span class="badge badge-danger">Pembayaran anda sedang di cek kasir</span>
                                                 <?php
                                                    } elseif ($status > 0) {
                                                    ?>
                                                     <span class="badge badge-info">DP Sudah di Acc kasir</span>
                                                 <?php
                                                    }
                                                    ?>
                                             </td>
                                             <td>
                                                 <a href="?halaman=detail&id=<?= $idpemesanan; ?>" class="btn btn-success">Detail</a>
                                                 <?php
                                                    if ($status == "2") {
                                                    ?>
                                                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bayarlunas<?= $idpemesanan; ?>">Bayar Pelunasan</button>
                                                 <?php
                                                    }
                                                    ?>
                                             </td>
                                         </tr>
                                         <div class="modal fade" id="bayarlunas<?= $idpemesanan; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                             <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                 <div class="modal-content">
                                                     <div class="modal-header">
                                                         <h5 class="modal-title" id="exampleModalLabel">Bayar Pelunasan</h5>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                             <span aria-hidden="true">&times;</span>
                                                         </button>
                                                     </div>
                                                     <div class="modal-body">
                                                         <?php
                                                            $cek_konsum = $koneksi->query("SELECT * FROM konsumen where id_konsumen='$data_id'");
                                                            $data_konsum = $cek_konsum->fetch_assoc();
                                                            ?>
                                                         <form method="post" action="bayar_lunas2.php" enctype="multipart/form-data">
                                                             <div class="form-group row">
                                                                 <label for="inputPassword" class="col-sm-3 col-form-label">Nama</label>
                                                                 <div class="col-sm-9">
                                                                     <input type="hidden" name="id_konsumen" value="<?= $id_konsumen; ?>">
                                                                     <input type="hidden" name="id_peminjaman" value="<?= $id_checkout; ?>">
                                                                     <input type="hidden" name="id_konsumen" value="<?= $data_id; ?>">
                                                                     <input type="hidden" name="id_pemesanan" value="<?= $idpemesanan; ?>">
                                                                     <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= $data_konsum['nama_konsumen']; ?>" readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="form-group row">
                                                                 <label for="inputPassword" class="col-sm-3 col-form-label">Alamat</label>
                                                                 <div class="col-sm-9">
                                                                     <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?= $data_konsum['alamat']; ?>" readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="form-group row">
                                                                 <label for="inputPassword" class="col-sm-3 col-form-label">No. Wa</label>
                                                                 <div class="col-sm-9">
                                                                     <input type="text" name="wa" class="form-control" placeholder="No. Wa" value="<?= $data_konsum['no_telp']; ?>" readonly>
                                                                 </div>
                                                             </div>
                                                             <?php
                                                                $keranjang_v = $koneksi->query("SELECT sum(total_bayar) as total_bayar, id_pemesanan, id_konsumen FROM v_keranjang where id_konsumen='$data_id' and id_pemesanan='$idpemesanan' and status between '0' and '2'");
                                                                $data_keranjang_v = $keranjang_v->fetch_assoc();
                                                                $total_bayar = $data_keranjang_v['total_bayar'];
                                                                $id_pesan = $data_keranjang_v['id_pemesanan'];
                                                                $id_konsumen = $data_keranjang_v['id_konsumen'];
                                                                ?>
                                                             <div class="form-group row">
                                                                 <label for="inputPassword" class="col-sm-3 col-form-label">Total Bayar</label>
                                                                 <div class="col-sm-9">
                                                                     <input type="text" name="wa" class="form-control" placeholder="No. Wa" value="<?= rupiah($data_keranjang_v['total_bayar']); ?>" readonly>
                                                                 </div>
                                                             </div>
                                                             <?php
                                                                $bayar = $koneksi->query("SELECT * FROM v_pembayaran where id_konsumen='$data_id' and id_pemesanan='$idpemesanan' and status_bayar between '0' and '1'");
                                                                $data_bayar = $bayar->fetch_assoc();
                                                                $nominal_dulu = $data_bayar['total'];
                                                                $kurang = $total_bayar - $nominal_dulu;
                                                                ?>
                                                             <div class="form-group row">
                                                                 <label for="inputPassword" class="col-sm-3 col-form-label">Sudah</label>
                                                                 <div class="col-sm-9">
                                                                     <input type="text" class="form-control" value="<?= rupiah($nominal_dulu); ?>" readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="form-group row">
                                                                 <label for="inputPassword" class="col-sm-3 col-form-label">Kurang</label>
                                                                 <div class="col-sm-9">
                                                                     <input type="text" class="form-control" value="<?= rupiah($kurang); ?>" readonly>
                                                                     <input type="hidden" name="nominal_bayar" class="form-control" value="<?= $kurang; ?>" required>
                                                                 </div>
                                                             </div>
                                                             <div class="form-group row">
                                                                 <label for="inputPassword" class="col-sm-3 col-form-label">Bukti Bayar</label>
                                                                 <div class="col-sm-9">
                                                                     <input type="file" name="bukti" class="form-control" required>
                                                                 </div>
                                                             </div>
                                                     </div>
                                                     <div class="modal-footer">
                                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                         <button type="submit" name="bayar_lunas" class="btn btn-primary">Kirim</button>
                                                     </div>
                                                     </form>
                                                 </div>
                                             </div>
                                         </div>
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