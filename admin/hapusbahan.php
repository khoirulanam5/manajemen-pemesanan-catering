<?php 
$ambil= $koneksi->query("SELECT * FROM bahan WHERE id_bahan='$_GET[id]'"); 
$pecah = $ambil->fetch_assoc();

$koneksi->query("DELETE FROM bahan WHERE id_bahan='$_GET[id]'");
echo "<script>alert('bahan terhapus')</script>";
echo "<script>location='index.php?halaman=bahan'</script>";
?>
