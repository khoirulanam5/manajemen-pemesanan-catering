 <section class="py-5">
     <div class="container px-4 px-lg-5 my-5">
         <div class="row">
             <div class="col-sm-12">
                 <div class="card text-center">
                     <div class="card-header">
                         <ul class="nav nav-tabs card-header-tabs">
                             <li class="nav-item">
                                 <a class="nav-link active" href="javascript.void(0);"><b>PROFIL</b></a>
                             </li>
                         </ul>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <table id="example" class="table table-striped" style="width:100%">
                                 <thead>
                                     <tr>
                                         <th>Nama</th>
                                         <th>No. wa</th>
                                         <th>Alamat</th>
                                         <th>Username</th>
                                         <th>Password</th>
                                         <th>Status</th>
                                         <th>Aksi</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                        $cek_profil = $koneksi->query("SELECT * FROM konsumen where id_konsumen = '$data_id'");
                                        while ($data_profil = $cek_profil->fetch_assoc()) {
                                            $nama_konsumen = $data_profil['nama_konsumen'];
                                            $no_wa = $data_profil['no_telp'];
                                            $alamat = $data_profil['alamat'];
                                            $username = $data_profil['username'];
                                            $password = $data_profil['password'];
                                            $idprofil = $data_profil['id_konsumen'];
                                            $status = $data_profil['status'];
                                        ?>
                                         <tr>
                                             <td><?= $nama_konsumen; ?></td>
                                             <td><?= $no_wa; ?></td>
                                             <td><?= $alamat; ?></td>
                                             <td><?= $username; ?></td>
                                             <td><?= $password; ?></td>
                                             <td>
                                                 <?php
                                                    if ($status == "1") {
                                                    ?>
                                                     <span class="badge badge-primary">Aktif</span>
                                                 <?php
                                                    } else {
                                                    ?>
                                                     <span class="badge badge-danger">Tidak Aktif</span>
                                                 <?php
                                                    }
                                                    ?>
                                             </td>
                                             <td>
                                                 <a href="?halaman=editprofil&id=<?= $idprofil; ?>" class="btn btn-warning">edit</a>
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