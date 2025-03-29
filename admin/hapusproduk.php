<?php 
$ambil= $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'"); 
$pecah = $ambil->fetch_assoc();
$fotoproduk = $pecah['foto'];
if (file_exists("img/$fotoproduk")) 
{
	unlink("img/$fotoproduk");
}

$koneksi->query("DELETE FROM produk WHERE id_produk='$_GET[id]'");
echo "<script>alert('produk terhapus')</script>";
echo "<script>location='index.php?halaman=produk'</script>";
?>
