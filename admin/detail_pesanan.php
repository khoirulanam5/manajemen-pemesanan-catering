<?php
error_reporting(0);
if (isset($_GET['id'])) {
    $idpemesanan = $_GET['id'];
    $cek = $koneksi->query("SELECT * FROM v_keranjang where id_pemesanan='$idpemesanan'");
    $row_cek = $cek->fetch_assoc();
    $status_cek = $row_cek['status'];
}
?>
<script>
    $(document).ready(function() {
        $(".kota10").change(function(e) {
            var total = $('.s').val();
            var total2 = $('.r').val();
            var total3 = $('.p').val();
            var nilai = $(".kota10").val();
            document.getElementById('stock').value = nilai;
            // }
        });

    });
</script>
<h2>Detail Pesanan</h2>
<br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Foto Produk</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Harga</th>
            <?php
            if ($data_level == "Dapur") {
                if ($status_cek == "2" || $status_cek == "3" || $status_cek == "4") {
            ?>
                    <th scope="col">Aksi</th>
            <?php
                } else {
                }
            }
            ?>

        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $cek = $koneksi->query("SELECT * from v_keranjang where id_pemesanan='$idpemesanan' and status between 1 and 4");
        while ($keranjang = $cek->fetch_assoc()) {
            $status = $keranjang['status'];
            $status2 = $keranjang['status_produk'];
            $idkeranjang = $keranjang['id_keranjang'];
            $qty = $keranjang['quantity_awal'];
            $x_porsi = $keranjang['x_porsi'];
            $produk = $keranjang['nama_produk'];
            $idproduk = $keranjang['id_produk'];
            $idpemesanan = $keranjang['id_pemesanan'];
        ?>
            <tr>
                <th scope="row"><?= $no++; ?></th>
                <td><img src="../img/<?= $keranjang['foto']; ?>" alt="" width="50px"></td>
                <td><?= $keranjang['nama_produk']; ?></td>
                <td><?= rupiah($keranjang['harga']); ?></td>
                <td><?= $keranjang['quantity_awal']; ?></td>
                <td><?= rupiah($keranjang['total_bayar']); ?></td>
                <?php
                if ($data_level == "Dapur") {
                    if ($status2 == "2") {
                ?>
                        <td>
                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#estimasi<?= $idkeranjang; ?>">Estimasi</a>
                        </td>
                    <?php
                    } else {
                    ?>
                        <td>
                            <span class="badge badge-info">sudah diestimasi</span>
                        </td>
                <?php
                    }
                }
                ?>

            </tr>
            <div class="modal fade" id="estimasi<?= $idkeranjang; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Halaman Estimasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" method="post">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="idproduk" value="<?= $produk; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Porsi</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="idkeranjang" value="<?= $idkeranjang; ?>">
                                        <input type="hidden" name="idpesan" value="<?= $idpemesanan; ?>">
                                        <input type="hidden" name="x_porsi" value="<?= $x_porsi; ?>">
                                        <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                                        <input type="text" name="qty" value="<?= $qty; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <h5>Resep / Bahan</h5>
                                        <hr>
                                        <?php
                                        $cekresep = $koneksi->query("select * from v_resep where id_produk='$idproduk'");
                                        while ($dataresep = $cekresep->fetch_assoc()) {
                                            $satuan = $dataresep['satuan'];
                                            $bahan = $dataresep['nama_bahan'];
                                            $jml = $dataresep['jml'];
                                            $data = $x_porsi * $jml;
                                            if ($data == "secukupnya") {
                                                $data = "secukupnya";
                                            }
                                            if ($satuan == "secukupnya") {
                                                $satuan = "";
                                            }
                                            echo "<b>" . $data . ' ' .  $satuan . "</b>" . ' ' . $bahan . "</br>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php
                                        echo "<h5>Stok Bahan Menipis / Habis</h5>";
                                        echo "<hr>";
                                        $cekbahan2 = $koneksi->query("select * from vv_resep where id_produk='$idproduk' and id_pemesanan='$idpemesanan'");
                                        $baris2 = $cekbahan2->num_rows;
                                        if ($baris2) {
                                            while ($databahan2 = $cekbahan2->fetch_assoc()) {
                                                $bahan = $databahan2['nama_bahan'];
                                                $jml_bahan = $databahan2['jml_bahan'];
                                                $total_porsi = $databahan2['total_porsi'];
                                                $satuan = $databahan2['satuan'];
                                                echo '<b><span class="badge badge-danger"> "' . $bahan . ', Stok : ' .  $jml_bahan . ' ' . $satuan . '"</span></b></br>';
                                            }
                                        } else {
                                            echo '<b><span class="badge badge-info">Stok Aman.</span></b>';
                                        }
                                        ?>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="?halaman=bahan" class="btn btn-warning">Ubah Bahan</a>
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

<?php
$keranjang_v = $koneksi->query("SELECT sum(total_bayar) as total_bayar, id_pemesanan, status FROM v_keranjang where id_pemesanan='$idpemesanan' and status='3'");
$data_keranjang_v = $keranjang_v->fetch_assoc();
$total_bayar = $data_keranjang_v['total_bayar'];
$status = $data_keranjang_v['status'];
?>
<table class="table">
    <thead class="thead-light">
        <?php if($status == '3'): ?>
        <tr>
            <th scope="col" colspan="5" style="text-align: center;">TOTAL BAYAR</th>
            <th scope="col" style="text-align: center;"><?= rupiah($total_bayar); ?></th>
            <?php
            if ($data_level == "Dapur") {
            ?>
                <th colspan="2">
                    <a href="?halaman=detailpesanan&notif=<?= $idpemesanan; ?>" 
                    class="btn btn-primary" 
                    id="pesananBtn">Pesanan Sudah Jadi</a>
                </th>
            <?php
            }
            ?>
        </tr>
        <?php endif; ?>
    </thead>
</table>
<br><br>
<h2>Rincian Pembayaran</h2>
<br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Tgl Bayar</th>
            <th scope="col">Tgl Pesan</th>
            <th scope="col">Tgl Ambil</th>
            <th scope="col">Jam Ambil</th>
            <th scope="col">Status Bayar</th>
            <th scope="col">Bukti</th>
            <th scope="col">Nominal Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $cek = $koneksi->query("SELECT * from v_pembayaran where id_pemesanan='$idpemesanan' and status between '1' and '4' group by id_pembayaran");
        while ($keranjang = $cek->fetch_assoc()) {
            $status_bayar = $keranjang['status_bayar'];
        ?>
            <tr>
                <th scope="row"><?= $no++; ?></th>
                <td><?= date("d-m-Y", strtotime($keranjang['tgl_bayar'])); ?></td>
                <td><?= date("d-m-Y", strtotime($keranjang['tgl_pesan'])); ?></td>
                <td><?= date("d-m-Y", strtotime($keranjang['tgl_ambil'])); ?></td>
                <td><?= date("H:i", strtotime($keranjang['jam_ambil'])); ?></td>
                <td>
                    <?php
                    if ($status_bayar == "0" || $status_bayar == "1") {
                        echo $status_bayar = "DP";
                    } elseif ($status_bayar == "2" || $status_bayar == "3") {
                        echo $status_bayar = "Lunas";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($keranjang['bukti_pembayaran'] == "") {
                        echo "bayar ditempat.";
                    } else {
                    ?>
                        <img src="../bukti/<?= $keranjang['bukti_pembayaran']; ?>" alt="" width="200px;">
                    <?php
                    }
                    ?>
                </td>
                <td><?= rupiah($keranjang['total']); ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php
$keranjang_v = $koneksi->query("SELECT sum(total) as total FROM v_pembayaran where id_pemesanan='$idpemesanan' and status between '1' and '4'");
$data_keranjang_v = $keranjang_v->fetch_assoc();
$total_bayar = $data_keranjang_v['total'];
?>
<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col" colspan="5" style="text-align: center;">NOMINAL BAYAR</th>
            <th scope="col" style="text-align: center;"><?= rupiah($total_bayar); ?></th>
        </tr>
    </thead>
</table>

<?php
if (isset($_POST['simpan'])) {
    $idkeranjang = $_POST['idkeranjang'];
    $cek = $koneksi->query("SELECT * FROM v_keranjang where id_keranjang='$idkeranjang'");
    $row_cek = $cek->fetch_assoc();
    $idproduk = $row_cek['id_produk'];
    $idpesan = $row_cek['id_pemesanan'];
    $idbahan = $_POST['idbahan'];
    $cek_bahan = $koneksi->query("SELECT * FROM bahan where id_bahan='$idbahan'");
    $row_cek_bahan = $cek_bahan->fetch_assoc();
    $jumlah_bahan = $row_cek_bahan['jumlah'];
    $cekestimasi = $koneksi->query("select * from estimasi_bahan where id_produk='$idproduk' and id_pemesanan='$idpemesanan'");
    $rowcekestimasi = $cekestimasi->num_rows;
    $jml = $_POST['jumlah'];
    $jumlah = $jumlah_bahan - $jml;

    if ($jumlah_bahan == "0") {
        echo "<script>alert('stock habis')</script>";
        echo "<script>location='index.php?halaman=detailpesanan&id=$idpemesanan'</script>";
    } else {

        if ($rowcekestimasi) {
            echo "<script>alert('sudah ada')</script>";
            echo "<script>location='index.php?halaman=detailpesanan&id=$idpemesanan'</script>";
        } else {

            $simpan = $koneksi->query("UPDATE bahan set jumlah='$jumlah' where id_bahan='$idbahan'");
            $simpan = $koneksi->query("INSERT INTO estimasi_bahan (id_pemesanan, id_bahan, id_produk, id_keranjang, jumlah) values ('$idpemesanan','$idbahan','$idproduk','$idkeranjang','$jml') ");
            $simpan = $koneksi->query("UPDATE detail_pemesanan set status='3' where id_keranjang='$idkeranjang'");

            if ($simpan) {
                echo "<script>alert('estimasi bahan berhasil ditambahkan')</script>";
                echo "<script>location='index.php?halaman=detailpesanan&id=$idpemesanan'</script>";
            }
        }
    }
}
if (isset($_POST['save'])) {
    $idpesan = $_POST['idpesan'];
    $idproduk = $_POST['idproduk'];
    $idkeranjang = $_POST['idkeranjang'];
    $x_porsi = $_POST['x_porsi'];
    $cekresep = $koneksi->query("select * from v_resep where id_produk='$idproduk'");
    $cekresep2 = $koneksi->query("select * from v_resep where id_produk='$idproduk'");
    $dtaresep = $cekresep2->fetch_assoc();
    $cekkonsumen = $koneksi->query("select * from v_keranjang where id_pemesanan='$idpesan'");
    $datakonsumen = $cekkonsumen->fetch_assoc();
    $no_wa_konsumen = $datakonsumen['no_telp'] . ", 6281904623215";
    $nama_produk = $dtaresep['nama_produk'];

    $cek = $koneksi->query("SELECT * FROM v_resep where id_produk='$idproduk'");
    $baris_bahan = $cek->num_rows;
    if ($baris_bahan == "0") {
        echo "<script>alert('Gagal dikirim, belum ada resepnya')</script>";
        echo "<script>location='index.php?halaman=detailpesanan&id=$idpesan'</script>";
    } else {
        while ($row = $cek->fetch_assoc()) {
            $id_bahan = $row['id_bahan'];
            $id_produk = $row['id_produk'];
            $cek_bahan = $koneksi->query("SELECT * FROM v_resep where id_bahan='$id_bahan'");
            while ($row2 = $cek_bahan->fetch_assoc()) {
                $jumlah = $row2['jumlah_awal'];
                $jml_x = $row2['jml'];
                $idbahan = $row2['id_bahan'];
                $porsi_x = $jml_x * $x_porsi;
                $x_kurang = $jumlah - $porsi_x;
                $nama_bahan = $row2['nama_bahan'];
                if ($jumlah == "0") {
                    echo "<script>alert('Gagal dikirim, ada stok bahan yg kosong')</script>";
                    echo "<script>location='index.php?halaman=estimasi'</script>";
                } elseif ($jumlah > "0") {
                    $koneksi->query("update bahan set jumlah='$x_kurang' where id_bahan='$idbahan'");
                    // $koneksi->query("update pemesanan set status='4' where id_pemesanan='$idpesan'");
                    $koneksi->query("update detail_pemesanan set status='3' where id_keranjang='$idkeranjang'");
                    echo '<script>alert("Berhasil diestimasi")</script>';
                    echo "<script>location = 'index.php?halaman=detailpesanan&id=$idpesan'</script>";
                    $curl = curl_init();
                    $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
                    $pesan = "*Info Estimasi Bahan*\n\nID pesan : *$idpesan*\nProduk : *$nama_produk*\nPorsi : *$qty*\nStatus : *Pesanan sudah diestimasi.*";
                    $pesan .= "\n\n*Resep* */* *Bahan*\n";
                    $pesan .= "===========================\n";
                    while ($resep = $cekresep->fetch_assoc()) {
                        $jml = $resep['jml'];
                        if ($jml == "secukupnya") {
                            $jml = "";
                        } else {
                            $jml = "*" . $jml * $x_porsi . "* ";
                        }
                        $pesan .= $jml . "*" . $resep['satuan'] . "*" . " " . $resep['nama_bahan'] . "\n";
                    }
                    $pesan .= "\n\nRegards,\nLina Catering ~ Kudus";
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
                    curl_setopt($curl, CURLOPT_URL, "https://kudus.wablas.com/api/send-message");
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    $result = curl_exec($curl);
                    curl_close($curl);
                    return json_decode($result, true);
                }
            }
        }
        // $qty = $row['quantity'];
        // $jml = $jml_brg + $qty;
        // $update = $koneksi->query("update barang set jumlah_brg='$jml' where id_barang='$id_barang'");

    }
} elseif (isset($_GET['notif'])) {
    $idpemesanan = $_GET['notif'];
    $cek = $koneksi->query("select * from v_pembayaran where id_pemesanan='$idpemesanan'");
    $row = $cek->fetch_assoc();
    $tgl_ambil = date("d-m-Y", strtotime($row['tgl_ambil']));
    $jam_ambil = $row['jam_ambil'];
    $tgl_pesan = date("d-m-Y", strtotime($row['tgl_pesan']));
    $total = $row['total'];
    $id_konsumen = $row['id_konsumen'];
    $idpemesanan = $row['id_pemesanan'];
    $total_bayar = rupiah($total);
    $no_wa_konsumen = $row['no_telp'] . "," . "6281904623215";
    // cek produk
    $cekproduk = $koneksi->query("SELECT * FROM vv_produk where id_pemesanan='$idpemesanan'");
    $rowproduk = $cekproduk->fetch_assoc();
    $produk = $rowproduk['nama_produk'];
    $harga_awal = $rowproduk['harga_awal'];
    $quantity_awal = $rowproduk['quantity_awal'];

    $ubah = $koneksi->query("update pemesanan set status='4' where id_konsumen='$id_konsumen' and id_pemesanan='$idpemesanan'");



    if ($ubah) {
        echo '<script>alert("Berhasil dikirim")</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=estimasi'>";
        $curl = curl_init();
        $token = 'diY7NmCX7gLl6QcvFKJonQAB6Jvn9MjjCxsI1eZko3e7nf0xSd1TC3i8qff0Wy9z';
        $pesan = "*Info Status Pemesanan*\n\nID pesan : *$idpemesanan*\nTgl Pesan : *$tgl_pesan*\nProduk : *$produk*\nHarga : *$harga_awal*\nQty : *$quantity_awal*\nTotal Harga : *{$total_bayar}*\n\n*Info Pembayaran,*\nStatus bayar : *Lunas*\nNominal Bayar : *{$total_bayar}*\n\n*Status Pesan,*\nStatus : *Pesanan sudah jadi.*\n\nRegards,\nLina Catering ~ Kudus";
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

<script>
document.getElementById("pesananBtn").addEventListener("click", function(event) {
    // Cek apakah ada elemen dengan class 'badge-danger'
    if (document.querySelector(".badge-danger")) {
        alert("Stok tidak mencukupi! Harap periksa kembali stok bahan.");
        event.preventDefault(); // Mencegah eksekusi href
    } else {
        return confirm("Anda yakin pesanan sudah diestimasi semua?");
    }
});
</script>
