<h2>Peminjaman Masuk</h2>
<br>
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Id pinjam</th>
            <th>Tgl pinjam</th>
            <th>Tgl kembali</th>
            <th>Nominal</th>
            <th>Nama konsumen</th>
            <th>Alamat konsumen</th>
            <th>No wa</th>
            <th>Status bayar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?php $nomor = 1; ?>
    <?php $ambil = $koneksi->query("SELECT * FROM v_pembayaran_pinjam where status between 1 and 4 group by id_peminjaman order by id_pembayaran desc"); ?>
    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
        <?php
        $idpinjam = $pecah['id_peminjaman'];
        $idbayar = $pecah['id_pembayaran'];
        $status_bayar = $pecah['status_bayar'];
        $status = $pecah['status'];
        if ($status_bayar == "0" || $status_bayar == "1") {
            $status_bayar = "DP";
        } else {
            $status_bayar = "Lunas";
        }
        ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['id_peminjaman']; ?></td>
            <td><?php echo date("d-m-Y", strtotime($pecah['tgl_pinjam'])); ?></td>
            <td><?php echo date("d-m-Y", strtotime($pecah['tgl_kembali'])); ?></td>
            <td><?php echo rupiah($pecah['total']); ?></td>
            <td><?php echo $pecah['nama_konsumen']; ?></td>
            <td><?php echo $pecah['alamat']; ?></td>
            <td><?php echo $pecah['no_telp']; ?></td>
            <td><?php echo $status_bayar; ?></td>
            <td>
                <?php
                if ($status == "1") {
                ?>
                    <a href="#" class="btn-primary btn" data-toggle="modal" data-target="#acc<?= $idbayar; ?>">acc</a>
                    <!-- <a href="#" class="btn-danger btn" data-toggle="modal" data-target="#exampleModal<?= $idpemesanan; ?>">tolak</a> -->
                <?php
                } elseif ($status >= "2") {
                ?>
                    <a href="cetak_nota_pinjam.php?id=<?= $idpinjam; ?>" class="btn btn-warning" target="_blank">cetak nota</a>
                <?php
                }
                ?>
                <a href="index.php?halaman=detailpinjam&id=<?= $idpinjam; ?>" class="btn-success btn">detail barang pinjam</a>
                <?php
                if ($status == "2") {
                ?>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#lunas<?= $idpinjam; ?>">bayar pelunasan</a>
                <?php
                } ?>


            </td>
        </tr>
        <?php $nomor++; ?>
        <div class="modal fade" id="lunas<?= $idpinjam; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Halaman ACC</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <?php
                            $keranjang = $koneksi->query("SELECT * FROM v_pembayaran_pinjam where id_peminjaman='$idpinjam'");
                            $data_keranjang = $keranjang->fetch_assoc();
                            $total_bayar = $data_keranjang['total_harga'];
                            $bayar = $koneksi->query("SELECT * FROM v_pembayaran_pinjam where id_peminjaman='$idpinjam'");
                            $data_bayar = $bayar->fetch_assoc();
                            $nominal_dulu = $data_bayar['total'];
                            $kurang = $total_bayar - $nominal_dulu;
                            ?>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Sudah</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="id_peminjaman" value="<?= $idpinjam; ?>">
                                    <input type="text" class="form-control" value="<?= rupiah($nominal_dulu); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Kurang</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?= rupiah($kurang); ?>" readonly>
                                    <input type="hidden" name="nominal" class="form-control" value="<?= $kurang; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Komentar</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="idbayar" value="<?= $idbayar; ?>">
                                    <textarea name="komentar" class="form-control" cols="30" rows="5" placeholder="komentar.."></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="pelunasan" class="btn btn-primary">ACC</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="acc<?= $idbayar; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Halaman ACC</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Status bayar</label>
                                <div class="col-sm-10">
                                    <select name="status_bayar" class="form-control">
                                        <option disabled="" selected="">Pilih status bayar</option>
                                        <option value="1">DP</option>
                                        <option value="3">Lunas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Komentar</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="idbayar" value="<?= $idbayar; ?>">
                                    <textarea name="komentar" class="form-control" cols="30" rows="5" placeholder="komentar.."></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="acc" class="btn btn-primary">ACC</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    </tbody>
</table>

<?php
if (isset($_POST['acc'])) {
    // $idpeminjaman = $_POST['idpinjam'];
    $idpembayaran = $_POST['idbayar'];
    $komentar = $_POST['komentar'];
    $status_bayar = $_POST['status_bayar'];
    $status_bayar2 = $_POST['status_bayar'];
    $status_bayar3 = $_POST['status_bayar'];
    $tgl_bayar = date("Y-m-d");
    $tgl_bayar2 = date("d-m-Y");
    if ($status_bayar == "0" || $status_bayar == "1") {
        $status_bayar = "DP";
    } elseif ($status_bayar == "2" || $status_bayar == "3") {
        $status_bayar = "Lunas";
    }
    // cek
    $cek = $koneksi->query("select * from v_pembayaran_pinjam where id_pembayaran='$idpembayaran'");
    $row = $cek->fetch_assoc();
    $no_wa_konsumen = $row['no_telp'];
    $tgl_pinjam = date("d-m-Y", strtotime($row['tgl_pinjam']));
    $tgl_ambil = date("d-m-Y", strtotime($row['tgl_ambil']));
    $tgl_kembali = date("d-m-Y", strtotime($row['tgl_kembali']));
    $total = $row['total'];
    $id_konsumen = $row['id_konsumen'];
    $idpeminjaman = $row['id_peminjaman'];
    $total_bayar = rupiah($total);

    // cek 
    $cek2 = $koneksi->query("SELECT sum(total_bayar) as total_bayar FROM v_pinjam where id_peminjaman='$idpeminjaman'");
    $row_cek = $cek2->fetch_assoc();
    $total_harga2 = rupiah($row_cek['total_bayar']);

    $ubah = $koneksi->query("update detail_peminjaman set status='2' where id_konsumen='$id_konsumen' and id_peminjaman='$idpeminjaman'");
    $ubah = $koneksi->query("update pembayaran_pinjam set status_bayar='$status_bayar2', tgl_bayar='$tgl_bayar', komentar='$komentar' where id_konsumen='$id_konsumen' and id_peminjaman='$idpeminjaman' and id_pembayaran='$idpembayaran'");
    if ($status_bayar3 == "3") {
        $ubah = $koneksi->query("update peminjaman set status='$status_bayar3' where id_konsumen='$id_konsumen' and id_peminjaman='$idpeminjaman'");
    } else {
        $ubah = $koneksi->query("update peminjaman set status='2' where id_konsumen='$id_konsumen' and id_peminjaman='$idpeminjaman'");
    }

    if ($ubah) {
        echo '<script>alert("ACC pembayaran berhasil")</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=peminjaman'>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Status Pembayaran Pinjam Barang*\n\nID pinjam : $idpeminjaman\nTgl Bayar : $tgl_bayar2\nTgl Pinjam : $tgl_pinjam\nTgl Ambil : $tgl_ambil\nTgl Kembali : $tgl_kembali\nTotal Bayar : *$total_harga2*\nStatus bayar : *$status_bayar*\nStatus : *Sudah diacc kasir. Terima kasih sudah belanja/pinjam barang.*\nNominal Bayar : *{$total_bayar}*\nKomentar : *$komentar*\n\n\nRegards,\nLina Catering ~ Kudus";
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
        echo '<script>alert("ACC gagal, ulangi acc")</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=peminjaman'>";
    }
} elseif (isset($_POST['pelunasan'])) {
    $status_bayar = $_POST['status_bayar'];
    $status_bayar2 = $_POST['status_bayar'];
    $tgl_bayar = date("Y-m-d");
    $tgl_bayar2 = date("d-m-Y", strtotime($tgl_bayar));
    if ($status_bayar2 == '0') {
        $status_bayar2 = "DP";
    } else {
        $status_bayar2 = "Lunas";
    }
    $id_checkout = $_POST['id_peminjaman'];
    $nominal = $_POST['nominal'];
    // $tgl_ambil = date("d-m-Y", strtotime($_POST['tgl_ambil']));
    $tgl_ambil1 = $_POST['tgl_ambil'];
    $total_bayar = rupiah($nominal);
    // cek wa
    $cek = $koneksi->query("SELECT * FROM v_pinjam where id_peminjaman='$id_checkout'");
    $row_cek = $cek->fetch_assoc();
    $no_wa_konsumen = $row_cek['no_telp'];
    $data_id = $row_cek['id_konsumen'];
    $tgl_pesan = date("d-m-Y", strtotime($row_cek['tgl_pinjam']));
    $tgl_ambil = date("d-m-Y", strtotime($row_cek['tgl_ambil']));
    $total_harga2 = rupiah($row_cek['total_bayar']);
    $bukti = $_FILES['bukti']['name'];
    $lokasi = $_FILES['bukti']['tmp_name'];
    // $no_wa_konsumen = "6287897315639";
    move_uploaded_file($lokasi, "bukti/$bukti");
    // cek 2
    $cek2 = $koneksi->query("SELECT * FROM vv_barang where id_peminjaman='$id_checkout'");
    $row_cek2 = $cek2->fetch_assoc();
    $namaproduk = $row_cek2['nama_barang'];
    $hargaproduk = $row_cek2['harga_awal'];
    $total_hari = $row_cek2['total_hari_awal'];
    $harga = rupiah($hargaproduk);
    $qtyproduk = $row_cek2['quantity_awal'];
    $ubah = $koneksi->query("insert into pembayaran_pinjam (id_peminjaman,id_konsumen,total,status_bayar,tgl_bayar) values ('$id_checkout','$data_id','$nominal','3','$tgl_bayar')");
    $ubah = $koneksi->query("update detail_peminjaman set status='1' where id_peminjaman='$id_checkout'");
    $ubah = $koneksi->query("update peminjaman set status='3' where id_peminjaman='$id_checkout'");
    // $ubah = $koneksi->query("update pembayaran_pinjaman set status='2' where id_peminjaman='$id_checkout'");
    if ($ubah) {
        echo "<script>alert('Data lunas')</script>";
        echo "<script>location='index.php?halaman=peminjaman'</script>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Status Pembayaran Pinjam Barang*\n\nID pinjam : $id_checkout\nTgTgl Bayar : $tgl_bayar2\nBarang : $namaproduk\nHarga : $hargaproduk\nTotal hari : $total_hari\nQty : $qtyproduk\nTotal Bayar : *$total_harga2*\nBayar : *Lunas*\nStatus : *Pembayaran anda sedang dicek kasir*\nTotal Bayar : *{$total_bayar}*\n\nRegards,Lina Catering ~ Kudus";
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
        echo "<script>alert('Data gagal dibayar')</script>";
        echo "<script>location='index.php?halaman=peminjaman'</script>";
    }
}

?>