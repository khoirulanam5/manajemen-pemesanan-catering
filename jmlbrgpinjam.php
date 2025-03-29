 <!-- Header-->
 <!-- <header class="bg-danger py-5">
            <div class="container px-4 px-lg-5 my-5">
                <b>DAFTAR MENU MAKANAN</b>
            </div>
        </header> -->
 <!-- Section-->
 <section class="py-5">
     <div class="container px-4 px-lg-5 my-5">
         <div class="alert alert-primary" role="alert">
             <a href="#" class="alert-link">Catatan : </a> Jika telat mengembalikan barang akan dikenai denda per hari sebesar <a href="#" class="alert-link">Rp. 20.000</a>
         </div>
         <div class="row">
             <div class="col-sm-12">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>JUMLAH BARANG PINJAM</b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <table id="example2" class="table table-striped" style="width:100%">
                                 <thead>
                                     <tr>
                                         <th>ID Peminjaman</th>
                                         <th>Tanggal Pinjam</th>
                                         <th>Tanggal Ambil</th>
                                         <th>Tanggal Kembali</th>
                                         <th>Aksi</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $cek = $koneksi->query("SELECT * FROM v_pinjam where id_konsumen = '$data_id' and status between  '1' and '3'  GROUP BY id_peminjaman");
                                        while ($data = $cek->fetch_assoc()) {
                                            $nama_konsumen = $data['nama_konsumen'];
                                            $tgl_pinjam = date("d-m-Y", strtotime($data['tgl_pinjam']));
                                            $tgl_kembali = date("d-m-Y", strtotime($data['tgl_kembali']));
                                            $tgl_ambil = date("d-m-Y", strtotime($data['tgl_ambil']));
                                            $tgl_bali = date("Y-m-d", strtotime($data['tgl_kembali']));
                                            $alamat = $data['alamat'];
                                            $idpeminjaman = $data['id_peminjaman'];
                                            $id_pinjam = $data['id_peminjaman'];
                                            $no_wa = $data['no_telp'];
                                            $idprofil = $data['id_konsumen'];
                                            $status = $data['status'];
                                            $status2 = $data['status'];
                                            $bukti = $data['bukti_pembayaran'];
                                            $namabarang = $data['nama_barang'];
                                            $qty = $data['quantity'];
                                            $total = $data['total_harga_pinjam'];
                                            $status_bayar = $data['status_bayar'];
                                            $status_bayar2 = $data['status_bayar'];
                                            $status_bayar3 = $data['status'];
                                            $status_pinjam = $data['status'];
                                            if ($status_bayar == "1" || $status_bayar == "2" || $status_bayar == "3") {
                                                $status_bayar = "Lunas";
                                            }
                                        ?>
                                         <tr>
                                             <td><?= $idpeminjaman; ?></td>
                                             <td><?= $tgl_pinjam; ?></td>
                                             <td><?= $tgl_ambil; ?></td>
                                             <td><?= $tgl_kembali; ?></td>
                                             <td>
                                                 <?php
                                                    $tgl_ini = date("Y-m-d");
                                                    if ($tgl_ini > $tgl_bali) {
                                                    ?>
                                                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong<?= $id_pinjam; ?>">
                                                         Kembalikan
                                                     </button>
                                                 <?php
                                                    } elseif ($tgl_bali != $tgl_ini) {
                                                    ?>
                                                     <span class="badge bg-info text-white">Masih dalam waktu pinjam</span>
                                                 <?php
                                                    } else {
                                                    ?>
                                                     <a href="?halaman=jmlbrgpinjam&id=<?= $id_pinjam; ?>" class="btn btn-warning">Kembalikan</a>
                                                 <?php
                                                    }
                                                    ?>
                                             </td>
                                         </tr>

                                         <div class="modal fade" id="exampleModalLong<?= $id_pinjam; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                             <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                 <div class="modal-content">
                                                     <div class="modal-header">
                                                         <h5 class="modal-title" id="exampleModalLongTitle">Info</h5>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                             <span aria-hidden="true">&times;</span>
                                                         </button>
                                                     </div>
                                                     <div class="modal-body">
                                                         <?php
                                                            $tgl_ini  = date("d-m-Y");
                                                            $tgl1 = strtotime($tgl_kembali);
                                                            $tgl2 = strtotime($tgl_ini);

                                                            $jarak = $tgl2 - $tgl1;

                                                            $hari = $jarak / 60 / 60 / 24;
                                                            $denda = 20000 * $hari;
                                                            ?>
                                                         <h5><strong>ANDA TELAT <?= $hari; ?> HARI, AKAN DIKENAI DENDA SEBESAR <?= rupiah($denda); ?></strong></h5><br>
                                                         <hr>
                                                         <form method="post" enctype="multipart/form-data">
                                                             <div class="form-group row">
                                                                 <label for="colFormLabelLg" class="col-sm-6 col-form-label col-form-label-lg"><strong>Upload Bukti Bayar Denda <span style="color:red">*</span></strong></label>
                                                                 <div class="col-sm-6">
                                                                     <input type="file" name="denda" class="form-control form-control-lg" required="">
                                                                 </div>
                                                             </div>
                                                             <hr>
                                                             <div class="form-group row">
                                                                 <label for="colFormLabelLg" class="col-sm-6 col-form-label col-form-label-lg">Tanggal Pinjam</label>
                                                                 <div class="col-sm-6">
                                                                     <input type="hidden" name="id" value="<?= $id_pinjam; ?>">
                                                                     <input type="hidden" name="hari" value=<?= $hari; ?>>
                                                                     <input type="hidden" name="denda" value=<?= $denda; ?>>
                                                                     <input type="hidden" name="tgl_pinjam" value=<?= $tgl_pinjam; ?>>
                                                                     <input type="hidden" name="tgl_ambil" value=<?= $tgl_ambil; ?>>
                                                                     <input type="hidden" name="tgl_kembali" value=<?= $tgl_kembali; ?>>
                                                                     <input type="email" value="<?= $tgl_pinjam; ?>" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg" readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="form-group row">
                                                                 <label for="colFormLabelLg" class="col-sm-6 col-form-label col-form-label-lg">Tanggal Ambil</label>
                                                                 <div class="col-sm-6">
                                                                     <input type="email" value="<?= $tgl_ambil; ?>" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg" readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="form-group row">
                                                                 <label for="colFormLabelLg" class="col-sm-6 col-form-label col-form-label-lg">Tanggal Kembali</label>
                                                                 <div class="col-sm-6">
                                                                     <input type="email" value="<?= $tgl_kembali; ?>" class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg" readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="list-group">
                                                                 <a href="#" class="list-group-item list-group-item-action list-group-item-info">
                                                                     Barang
                                                                 </a>
                                                                 <?php
                                                                    $cek3 = $koneksi->query("SELECT * FROM v_pinjam where id_peminjaman = '$id_pinjam'");
                                                                    while ($row3 = $cek3->fetch_assoc()) {
                                                                        $barang = $row3['nama_barang'];
                                                                        $qty = $row3['quantity'];
                                                                    ?>
                                                                     <a href="#" class="list-group-item list-group-item-action"><?= $barang; ?>, Qty = <?= $qty; ?></a>
                                                                 <?php
                                                                    }
                                                                    ?>
                                                             </div>
                                                     </div>
                                                     <div class="modal-footer">
                                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                         <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>
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

 <?php
    if (isset($_POST['kirim'])) {
        $tglbyrdenda = date("Y-m-d");
        $idpinjam = $_POST['id'];
        $hari = $_POST['hari'];
        $denda = rupiah($_POST['denda']);
        $denda2 = $_POST['denda'];
        $tgl_ambil = $_POST['tgl_ambil'];
        $tgl_deadline = $_POST['tgl_kembali'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $tgl_pengembalian = date("d-m-Y");
        $bukti_denda = $_FILES['denda']['name'];
        $lokasi = $_FILES['denda']['tmp_name'];
        // $no_wa_konsumen = "6287897315639";
        move_uploaded_file($lokasi, "denda/$bukti_denda");
        // cek before
        $cek_before = $koneksi->query("SELECT * FROM vv_barang where id_peminjaman='$idpinjam'");
        $data_before = $cek_before->fetch_assoc();
        $namakonsumen = $data_before['nama_konsumen'];
        $nmbrg = $data_before['nama_barang'];
        $qtybrg = $data_before['quantity_awal'];
        $stock_awal = $data_before['jml_brg'];
        $id_konsum = $data_before['id_konsumen'];
        $no_wa_konsumen = $data_before['no_telp'] . "," . "6281904623215";

        $cek = $koneksi->query("SELECT * FROM v_pinjam where id_peminjaman='$idpinjam'");
        while ($row = $cek->fetch_assoc()) {
            $id_barang = $row['id_barang'];
            $cek_barang = $koneksi->query("SELECT * FROM barang where id_barang='$id_barang'");
            while ($row2 = $cek_barang->fetch_assoc()) {
                $jml_brg = $row['jumlah_brg'];
            }
            $qty = $row['quantity'];
            $jml = $jml_brg + $qty;
            $update = $koneksi->query("update barang set jumlah_brg='$jml' where id_barang='$id_barang'");
        }
        $update = $koneksi->query("update peminjaman set status='4' where id_peminjaman='$idpinjam'");
        $insert = $koneksi->query("INSERT INTO denda (id_konsumen,id_peminjaman,bukti_denda,jumlah_denda,tgl_bayar_denda) values ('$id_konsum','$idpinjam','$bukti_denda','$denda2','$tglbyrdenda')");
        $cek_after = $koneksi->query("SELECT * FROM vv_barang where id_peminjaman='$idpinjam'");
        $data_after = $cek_after->fetch_assoc();
        $stock_akhir = $data_after['jml_brg'];
        echo "<script>alert('Data berhasil dikembalikan')</script>";
        echo "<script>location='index.php?halaman=jmlbrgpinjam'</script>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Pengembalian Barang*\n\nNama Konsumen : *$namakonsumen*\nID pinjam : $idpinjam\nTgl Pinjam : $tgl_pinjam\nTgl Ambil : $tgl_ambil\nTgl Deadline : *$tgl_deadline*\nTgl Pengembalian : *$tgl_pengembalian*\nBarang : $nmbrg\nStock awal : $stock_awal\nQty yg dikembalikan : $qtybrg\nStock akhir : $stock_akhir\nTelat : $hari Hari\nDenda : *{$denda}*\nStatus : *Sudah dikembalikan.*\n\nRegards,\nLina Catering ~ Kudus";
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
    } elseif (isset($_GET['id'])) {
        $idpinjam = $_GET['id'];
        $tgl_pengembalian = date("d-m-Y");
        // cek before
        $cek_before = $koneksi->query("SELECT * FROM vv_barang where id_peminjaman='$idpinjam'");
        $data_before = $cek_before->fetch_assoc();
        $namakonsumen = $data_before['nama_konsumen'];
        $nmbrg = $data_before['nama_barang'];
        $qtybrg = $data_before['quantity_awal'];
        $stock_awal = $data_before['jml_brg'];
        $id_konsum = $data_before['id_konsumen'];
        $no_wa_konsumen = $data_before['no_telp'] . "," . "6281904623215";

        $cek = $koneksi->query("SELECT * FROM v_pinjam where id_peminjaman='$idpinjam'");
        while ($row = $cek->fetch_assoc()) {
            $id_barang = $row['id_barang'];
            $cek_barang = $koneksi->query("SELECT * FROM barang where id_barang='$id_barang'");
            while ($row2 = $cek_barang->fetch_assoc()) {
                $jml_brg = $row['jumlah_brg'];
            }
            $qty = $row['quantity'];
            $jml = $jml_brg + $qty;
            $update = $koneksi->query("update barang set jumlah_brg='$jml' where id_barang='$id_barang'");
        }
        $update = $koneksi->query("update peminjaman set status='4' where id_peminjaman='$idpinjam'");
        $cek_after = $koneksi->query("SELECT * FROM vv_barang where id_peminjaman='$idpinjam'");
        $data_after = $cek_after->fetch_assoc();
        $stock_akhir = $data_after['jml_brg'];
        echo "<script>alert('Data berhasil dikembalikan')</script>";
        echo "<script>location='index.php?halaman=jmlbrgpinjam'</script>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Pengembalian Barang*\n\nNama Konsumen : *$namakonsumen*\nID pinjam : $idpinjam\nTgl Pinjam : $tgl_pinjam\nTgl Pengembalian : *$tgl_pengembalian*\nBarang : $nmbrg\nStock awal : $stock_awal\nQty yg dikembalikan : $qtybrg\nStock akhir : $stock_akhir\nStatus : *Sudah dikembalikan.*\n\nRegards,\nLina Catering ~ Kudus";
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
    }
    ?>