<h2>Pesanan Masuk</h2>
<br>
<div class="table-responsive">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Aksi</th>
                <th>Id pesan</th>
                <th>Tgl pesan</th>
                <th>Tgl ambil</th>
                <th>Jam ambil</th>
                <th>Nominal bayar</th>
                <th>Bukti Pembayaran</th>
                <th>Status bayar</th>
                <th>Nama konsumen</th>
                <th>Alamat konsumen</th>
                <th>No wa</th>
            </tr>
        </thead>
        <?php $nomor = 1; ?>
        <?php $ambil = $koneksi->query("SELECT * FROM v_pembayaran WHERE status IN ('2', '3', '4', '5') GROUP BY id_pemesanan ORDER BY id_pemesanan DESC"); ?>
        <?php
        while ($pecah = $ambil->fetch_assoc()) {
            $idbayar = $pecah['id_pembayaran'];
            $status = $pecah['status'];
            $status_bayar = $pecah['status_bayar'];
            
            if ($status_bayar == "2" || $status_bayar == "3") {
                $status_bayar = "Lunas";
            } elseif ($status_bayar == "1") { // Gunakan elseif untuk kondisi lain
                $status_bayar = "DP";
            } else {
                $status_bayar = "Belum Bayar"; // Tambahkan kondisi default jika perlu
            }            
        ?>
            <?php
            $idpemesanan = $pecah['id_pemesanan'];
            ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td>
                    <?php
                    if ($status == "3") {
                    ?>
                        <a href="index.php?halaman=detailpesanan&id=<?= $idpemesanan; ?>" class="btn-success btn">detail pesanan</a>
                    <?php
                    } elseif ($status == "4") {
                    ?>
                        <a href="?halaman=estimasi&sudah=<?= $idpemesanan; ?>" class="btn-warning btn" onclick="return(confirm('Anda yakin pesanan sudah diambil ?'))">pesanan sudah diambil</a>
                        <!-- <a href="index.php?halaman=detailpesanan&id=<?= $idpemesanan; ?>" class="btn-success btn">detail pesanan</a> -->
                    <?php
                    } elseif ($status == "5") {
                    ?>
                        <a href="#" class="badge badge-info">Pesanan Selesai</a>
                    <?php
                    } else {
                    ?>
                        <a href="index.php?halaman=detailpesanan&id=<?= $idpemesanan; ?>" class="btn-success btn">detail pesanan</a>
                    <?php
                    }
                    ?>
                </td>
                <td><?php echo $pecah['id_pemesanan']; ?></td>
                <td><?php echo do_formal_date($pecah['tgl_pesan']); ?></td>
                <td><?php echo do_formal_date($pecah['tgl_ambil']); ?></td>
                <td><?php echo $pecah['jam_ambil']; ?></td>
                <td><?php echo rupiah($pecah['total']); ?></td>
                <td>
                    <img src="../bukti/<?php echo $pecah['bukti_pembayaran']; ?>" width="100">
                </td>
                <td><?= $status_bayar; ?></td>
                <td><?php echo $pecah['nama_konsumen']; ?></td>
                <td><?php echo $pecah['alamat']; ?></td>
                <td><?php echo $pecah['no_telp']; ?></td>
            </tr>
            <?php $nomor++; ?>
            <div class="modal fade" id="acc<?= $idpemesanan; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Halaman Estimasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Komentar</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="idpesan" value="<?= $idpemesanan; ?>">
                                        <textarea name="komentar" class="form-control" cols="30" rows="5" placeholder="komentar.."></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Tanggal Ambil</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="tgl_ambil" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Jam Ambil</label>
                                    <div class="col-sm-10">
                                        <input type="time" name="jam_ambil" class="form-control">
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="acc" class="btn btn-primary">Kirim</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="estimasi<?= $idpemesanan; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Halaman Estimasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Bahan</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="idpesan" value="<?= $idpemesanan; ?>">
                                        <select name="" id="">
                                            <option value="">1</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="acc" class="btn btn-primary">Kirim</button>
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
    $idpemesanan = $_POST['idpesan'];
    $komentar = $_POST['komentar'];
    $tgl_ambil = $_POST['tgl_ambil'];
    $jam_ambil = $_POST['jam_ambil'];
    $cek = $koneksi->query("select * from v_pembayaran where id_pemesanan='$idpemesanan'");
    $row = $cek->fetch_assoc();
    $no_wa_konsumen = $row['no_telp'] . "," . "6282323647641";
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $total = $row['total'];
    $id_konsumen = $row['id_konsumen'];
    $idpemesanan = $row['id_pemesanan'];
    $total_bayar = rupiah($total);
    // cek produk
    $cekproduk = $koneksi->query("SELECT * FROM vv_produk where id_pemesanan='$idpemesanan'");
    $rowproduk = $cekproduk->fetch_assoc();
    $produk = $rowproduk['nama_produk'];
    $harga_awal = $rowproduk['harga_awal'];
    $quantity_awal = $rowproduk['quantity_awal'];

    $ubah = $koneksi->query("update pemesanan set status='4', tgl_ambil='$tgl_ambil', jam_ambil='$jam_ambil' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");



    if ($ubah) {
        echo '<script>alert("Berhasil dikirim")</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=estimasi'>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Status Pemesanan*\n\nID pesan : *$idpemesanan*\nTgl Pesan : *$tgl_pesan*\nProduk : *$produk*\nHarga : *$harga_awal*\nQty : *$quantity_awal*\nTotal Harga : *{$total_bayar}*\n\n*Info Pembayaran,*\nStatus bayar : *Lunas*\nNominal Bayar : *{$total_bayar}*\n\n*Status Pesan,*\nStatus : *Sudah diacc dapur*\nKomentar : *$komentar*\nTanggal Ambil : *$tgl_ambil*\nJam Ambil : *$jam_ambil*\n\nRegards,\nLina Catering ~ Kudus";
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
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=estimasi'>";
    }
} elseif (isset($_GET['sudah'])) {
    $idpemesanan = $_GET['sudah'];
    $cek = $koneksi->query("select * from v_pembayaran where id_pemesanan='$idpemesanan'");
    $row = $cek->fetch_assoc();
    $tgl_ambil = date("d-m-Y", strtotime($row['tgl_ambil']));
    $jam_ambil = $row['jam_ambil'];
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $total = $row['total'];
    $id_konsumen = $row['id_konsumen'];
    $idpemesanan = $row['id_pemesanan'];
    $total_bayar = rupiah($total);
    $no_wa_konsumen = $row['no_telp'] . "," . "6282323647641";
    // cek produk
    $cekproduk = $koneksi->query("SELECT * FROM vv_produk where id_pemesanan='$idpemesanan'");
    $rowproduk = $cekproduk->fetch_assoc();
    $produk = $rowproduk['nama_produk'];
    $harga_awal = $rowproduk['harga_awal'];
    $quantity_awal = $rowproduk['quantity_awal'];

    $ubah = $koneksi->query("update pemesanan set status='5' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");



    if ($ubah) {
        echo '<script>alert("Berhasil dikirim")</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=estimasi'>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Status Pemesanan*\n\nID pesan : *$idpemesanan*\nTgl Pesan : *$tgl_pesan*\nProduk : *$produk*\nHarga : *$harga_awal*\nQty : *$quantity_awal*\nTotal Harga : *{$total_bayar}*\n\n*Info Pembayaran,*\nStatus bayar : *Lunas*\nNominal Bayar : *{$total_bayar}*\n\n*Status Pesan,*\nStatus : *Sudah diambil.*\nTanggal ambil : *$tgl_ambil*\nJam ambil : *$jam_ambil*\n\nRegards,\nLina Catering ~ Kudus";

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
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=estimasi'>";
    }
}
?>