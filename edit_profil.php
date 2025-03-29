<?php
if (isset($_GET['id'])) {
    $idprofil = $_GET['id'];
    $cek_profil = $koneksi->query("select * from konsumen where id_konsumen='$idprofil'");
    $data_profil = $cek_profil->fetch_assoc();
    $namakonsumen = $data_profil['nama_konsumen'];
    $nowa = $data_profil['no_telp'];
    $alamat = $data_profil['alamat'];
    $username = $data_profil['username'];
    $password = $data_profil['password'];
}
?>
<!-- Header-->
<!-- <header class="bg-danger py-5">
            <div class="container px-4 px-lg-5 my-5">
                <b>DAFTAR MENU MAKANAN</b>
            </div>
        </header> -->
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript.void(0);"><b>UBAH PROFIL</b></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nama" class="form-control" id="staticEmail" placeholder="Nama" value="<?= $namakonsumen; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">No. Wa</label>
                                <div class="col-sm-10">
                                    <input type="text" name="no_wa" class="form-control" id="staticEmail" placeholder="No. WA" value="<?= $nowa; ?>">
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" name="alamat" class="form-control" id="staticEmail" placeholder="Alamat" value="<?= $alamat; ?>">
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" class="form-control" id="staticEmail" placeholder="Username" value="<?= $username; ?>">
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="text" name="password" class="form-control" id="inputPassword" placeholder="Password" value="<?= $password; ?>">
                                </div>
                            </div>
                            <button type="submit" name="ubahprofil" class="btn btn-warning">Ubah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
if (isset($_POST['ubahprofil'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nowa = $_POST['no_wa'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $ubah = $koneksi->query("update konsumen set nama_konsumen='$nama', no_telp='$nowa', alamat='$alamat', username='$username', password='$password' where id_konsumen='$idprofil'");

    if ($ubah) {
        echo "<script>alert('Data berhasil diubah')</script>";
        echo "<script>location='?halaman=profil'</script>";
    } else {
        echo "<script>alert('Data gagal diubah')</script>";
        echo "<script>location='?halaman=editprofil&id=$idprofil'</script>";
    }
}
?>