<?php
  session_start();
  include "config/koneksi.php"; 

    $alert_message = ""; // Variabel untuk menyimpan pesan alert

    if (isset($_POST['login'])) {  
        //anti inject sql
        $username=mysqli_real_escape_string($koneksi,$_POST['username']);
        $password=mysqli_real_escape_string($koneksi,$_POST['password']);

        //query login
        $sql_login = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $query_login = mysqli_query($koneksi, $sql_login);
        $data_login = mysqli_fetch_array($query_login,MYSQLI_BOTH);
        $jumlah_login = mysqli_num_rows($query_login);


        if ($jumlah_login == 1) {
            $_SESSION["ses_id"] = $data_login["id_user"];
            $_SESSION["ses_nama"] = $data_login["nama_pengguna"];
            $_SESSION["ses_username"] = $data_login["username"];
            $_SESSION["ses_password"] = $data_login["password"];
            $_SESSION["ses_level"] = $data_login["level"];

            $alert_message = "<div class='alert alert-info text-center'>Login Sukses</div>";
            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
        } else {
            $alert_message = "<div class='alert alert-danger text-center'>Login Gagal</div>";
            echo "<meta http-equiv='refresh' content='1;url=login.php'>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lina Catering</title>
    <link rel= "icon" href="../img/DM.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background-image:url(../img/wepe.jpg);background-size:cover;">
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            
            <div class="col-xl-9 col-lg-10 col-md-9">
                <?= $alert_message; ?>
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"><img src="../img/DM.PNG" width="425px"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-1">Selamat Datang</h1>
                                        <p class="text-gray-900 mb-4">Alamat: Desa Kedungsari, Kec. Gebog, Kab. Kudus, Jawa tengah</p>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Username" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit"  class="btn btn-warning btn-user btn-block mb-3" name="login" title="Masuk Sistem">
                                            Login
                                        </button>
                                        <div class="text-center">
                                            <a href="../index.php">Kembali ke Home</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
