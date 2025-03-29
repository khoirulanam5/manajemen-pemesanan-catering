<h2>Pesanan Masuk</h2>
<br>
<div class="table-responsive">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Id pesan</th>
                <th>Tgl pesan</th>
                <th>Tgl ambil</th>
                <th>Jam ambil</th>
                <th>Nominal bayar</th>
                <th>Nama konsumen</th>
                <th>Alamat konsumen</th>
                <th>No wa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php $nomor = 1; ?>
        <?php $ambil = $koneksi->query("SELECT * FROM v_pembayaran where status between 1 and 3 group by id_pemesanan order by id_pembayaran DESC"); ?>
        <?php
        while ($pecah = $ambil->fetch_assoc()) {
            $idbayar = $pecah['id_pembayaran'];
            $status_bayar = $pecah['status_bayar'];
            $status_bayar2 = $pecah['status_bayar'];
            $status = $pecah['status'];
            if ($status_bayar == "0" || $status_bayar == "1") {
                $status_bayar = "DP";
            } elseif ($status_bayar == "2" || $status_bayar == "3") {
                $status_bayar = "Lunas";
            }
        ?>
            <?php
            $idpemesanan = $pecah['id_pemesanan'];
            ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $pecah['id_pemesanan']; ?></td>
                <td><?php echo date("d-m-Y", strtotime($pecah['tgl_pesan'])); ?></td>
                <td><?php echo date("d-m-Y", strtotime($pecah['tgl_ambil'])); ?></td>
                <td><?php echo $pecah['jam_ambil']; ?></td>
                <td><?php echo rupiah($pecah['total']); ?></td>
                <td><?php echo $pecah['nama_konsumen']; ?></td>
                <td><?php echo $pecah['alamat']; ?></td>
                <td><?php echo $pecah['no_telp']; ?></td>
                <td>
                    <?php
                    if ($status == "1") {
                    ?>
                        <a href="#" class="btn-primary btn" data-toggle="modal" data-target="#acc<?= $idpemesanan; ?>">acc</a>
                        <a href="#" class="btn-danger btn" data-toggle="modal" data-target="#exampleModal<?= $idpemesanan; ?>">tolak</a>
                    <?php
                    } elseif ($status >= "2") {
                    ?>
                        <a href="cetak_nota.php?id=<?= $idpemesanan; ?>" class="btn btn-warning" target="_blank">cetak nota</a>
                    <?php
                    }
                    ?>
                    <a href="index.php?halaman=detailpesanan&id=<?= $idpemesanan; ?>" class="btn-success btn">detail pesanan</a>
                    <?php
                    if ($status == "2") {
                    ?>
                        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#pelunasan<?= $idpemesanan; ?>">bayar pelunasan</a>
                    <?php
                    } ?>
                </td>
            </tr>
            <?php $nomor++; ?>
            <div class="modal fade" id="pelunasan<?= $idpemesanan; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                $keranjang = $koneksi->query("SELECT * FROM v_keranjang where id_pemesanan='$idpemesanan'");
                                $data_keranjang = $keranjang->fetch_assoc();
                                $total_bayar = $data_keranjang['total_bayar'];
                                $bayar = $koneksi->query("SELECT * FROM v_pembayaran where id_pemesanan='$idpemesanan'");
                                $data_bayar = $bayar->fetch_assoc();
                                $nominal_dulu = $data_bayar['total'];
                                $kurang = $total_bayar - $nominal_dulu;
                                ?>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Sudah</label>
                                    <div class="col-sm-10">
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
            <?php 
                // Pastikan idpemesanan didefinisikan sebelum digunakan
                $status = $koneksi->query("SELECT * FROM v_pembayaran WHERE id_pemesanan = '$idpemesanan'");
                $row = $status->fetch_assoc(); // Ambil hasil query
            ?>

            <div class="modal fade" id="acc<?= $idpemesanan; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <label for="status_bayar" class="col-sm-2 col-form-label">Status bayar</label>
                                    <div class="col-sm-10">
                                    <select name="status_bayar" class="form-control" required>
                                            <option value="">Pilih status bayar</option>
                                            <?php if (!empty($row)): ?>
                                                <?php if ($row['status_bayar'] == '0'): ?>
                                                    <option value="1">DP</option>
                                                <?php elseif ($row['status_bayar'] == '1'): ?>
                                                    <option value="3">DP Lunas</option>
                                                <?php elseif ($row['status_bayar'] == '2'): ?>
                                                    <option value="3">Lunas</option>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <option value="">Tidak ada data status bayar</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="komentar" class="col-sm-2 col-form-label">Komentar</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="idbayar" value="<?= isset($idbayar) ? $idbayar : ''; ?>">
                                        <textarea name="komentar" class="form-control" cols="30" rows="5" placeholder="komentar.." required></textarea>
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
            <div class="modal fade" id="exampleModal<?= $idpemesanan; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">tolak</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Komentar</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="idpemesanan" value="<?= $idpemesanan; ?>" class="form-control" id="inputPassword" placeholder="Password">
                                        <textarea name="komentar" id="" cols="30" rows="10" class="form-control" placeholder="Komentar.."></textarea>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="tolak" class="btn btn-primary">Kirim</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php
if (isset($_POST['acc'])) {
    $idpembayaran = $_POST['idbayar'];
    $komentar = $_POST['komentar'];
    $status_bayar2 = $_POST['status_bayar'];
    $status_bayar3 = $_POST['status_bayar'];
    $status_bayar4 = $_POST['status_bayar'];
    if ($status_bayar4 == "0" || $status_bayar4 == "1") {
        $status_bayar4 = "DP";
    } elseif ($status_bayar4 == "2" || $status_bayar4 == "3") {
        $status_bayar4 = "Lunas";
    }
    // cek
    $cek = $koneksi->query("select * from v_pembayaran where id_pembayaran='$idpembayaran'");
    $row = $cek->fetch_assoc();
    $no_wa_konsumen = $row['no_telp'];
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $tgl_ambil = date("d-m-Y", strtotime($row['tgl_ambil']));
    $jam_ambil = $row['jam_ambil'];
    $total = $row['total'];
    $id_konsumen = $row['id_konsumen'];
    $idpemesanan = $row['id_pemesanan'];
    $total_bayar = rupiah($total);

    // cek total harga
    $cek_tot_harga = $koneksi->query("select sum(total_bayar) as total_harga from v_keranjang where id_pemesanan='$idpemesanan'");
    $row_tot_harga = $cek_tot_harga->fetch_assoc();
    $total_harga = $row_tot_harga['total_harga'];

    $ubah = $koneksi->query("update detail_pemesanan set status='2' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");
    $ubah = $koneksi->query("update pembayaran set status_bayar='$status_bayar2', komentar='$komentar' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan' and id_pembayaran='$idpembayaran'");
    if ($status_bayar3 == "3") {
        $ubah = $koneksi->query("update pemesanan set status='$status_bayar3' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");
    } else {
        $ubah = $koneksi->query("update pemesanan set status='2' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");
    }


    if ($ubah) {
        echo '<script>alert("ACC pembayaran berhasil")</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=pesanan'>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Status Pembayaran*\n\nID pesan : $idpemesanan\nTgl Pesan : $tgl_pesan\nTgl Ambil : $tgl_ambil\nJam Ambil : $jam_ambil\nTotal harga : *$total_harga*\nStatus bayar : *$status_bayar4*\nStatus : *Sudah diacc kasir. Terima kasih sudah belanja.*\nNominal Bayar : *{$total_bayar}*\nKomentar : *$komentar*\n\nRegards,\nLina Catering ~ Kudus";
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
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=pesanan'>";
    }
} elseif (isset($_POST['tolak'])) {
    $idpemesanan = $_POST['idpemesanan'];
    $tolak = $_POST['komentar'];
    // cek
    $cek = $koneksi->query("select * from v_pembayaran where id_pemesanan='$idpemesanan'");
    $row = $cek->fetch_assoc();
    $no_wa_konsumen = $row['no_telp'];
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $tgl_ambil = date("d-m-Y", strtotime($row['tgl_ambil']));
    $jam_ambil = $row['jam_ambil'];
    $total = $row['total'];
    $id_konsumen = $row['id_konsumen'];
    $total_bayar = rupiah($total);
    // $no_wa_konsumen = "6287897315639";

    $hapus = $koneksi->query("delete from detail_pemesanan where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");
    $hapus = $koneksi->query("delete from pemesanan where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");
    $hapus = $koneksi->query("delete from pembayaran where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");

    if ($hapus) {
        echo '<script>alert("Tolak data berhasil")</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=pesanan'>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Status Pemesanan*\n\nID pesan : $idpemesanan\nTgl Pesan : $tgl_pesan\nTgl Ambil : $tgl_ambil\nJam Ambil : $jam_ambil\nStatus : *$tolak*\nNominal Bayar : *{$total_bayar}*\n\nRegards,\nLina Catering ~ Kudus";
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
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=pesanan'>";
    }
} elseif (isset($_POST['pelunasan'])) {
    $idpembayaran = $_POST['idbayar'];
    $komentar = $_POST['komentar'];
    $nominal = $_POST['nominal'];
    $status_bayar2 = $_POST['status_bayar'];
    $status_bayar3 = $_POST['status_bayar'];
    $status_bayar4 = $_POST['status_bayar'];
    if ($status_bayar4 == "0" || $status_bayar4 == "1") {
        $status_bayar4 = "DP";
    } elseif ($status_bayar4 == "2" || $status_bayar4 == "3") {
        $status_bayar4 = "Lunas";
    }
    // cek
    $cek = $koneksi->query("select * from v_pembayaran where id_pembayaran='$idpembayaran'");
    $row = $cek->fetch_assoc();
    $no_wa_konsumen = $row['no_telp'];
    $tgl_bayar = date("Y-m-d");
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $tgl_ambil = date("d-m-Y", strtotime($row['tgl_ambil']));
    $jam_ambil = $row['jam_ambil'];
    $total = $row['total'];
    $id_konsumen = $row['id_konsumen'];
    $idpemesanan = $row['id_pemesanan'];
    $total_bayar = rupiah($total);
    // $no_wa_konsumen = "6287897315639";

    // cek total harga
    $cek_tot_harga = $koneksi->query("select sum(total_bayar) as total_harga from v_keranjang where id_pemesanan='$idpemesanan'");
    $row_tot_harga = $cek_tot_harga->fetch_assoc();
    $total_harga = $row_tot_harga['total_harga'];

    $ubah = $koneksi->query("insert into pembayaran (id_pemesanan,id_konsumen,total,status_bayar,tgl_bayar) values ('$idpemesanan','$id_konsumen','$nominal','3','$tgl_bayar')");
    $ubah = $koneksi->query("update detail_pemesanan set status='2' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");
    $ubah = $koneksi->query("update pemesanan set status='3' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");

    if ($ubah) {
        echo '<script>alert("ACC pembayaran berhasil")</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=pesanan'>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Status Pembayaran*\n\nID pesan : $idpemesanan\nTgl Pesan : $tgl_pesan\nTgl Ambil : $tgl_ambil\nJam Ambil : $jam_ambil\nTotal harga : *$total_harga*\nStatus bayar : *Lunas*\nStatus : *Sudah diacc kasir. Terima kasih sudah belanja.*\nNominal Bayar : *{$total_bayar}*\nKomentar : *$komentar*\n\nRegards,\nLina Catering ~ Kudus";
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
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=pesanan'>";
    }
}
?>