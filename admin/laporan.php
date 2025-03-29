<h2>LAPORAN</h2>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Laporan Pesanan</th>
                <th scope="col">
                    <form method="POST" action="cetak_laporan_pemesanan.php">
                        <select name="bulan" class="form-control" required>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                </th>
                <th scope="col">
                    <input type="number" name="tahun" class="form-control" placeholder="Tahun" required>
                </th>
                <th scope="col">
                    <button type="submit" name="cetak" class="btn btn-info">
                        <i class="fas fa-print" style="font-size: 30px;"></i>
                    </button>
                    </form>
                </th>
                <th scope="col">
                    <a href="cetak_laporan_pemesanan.php" class="btn btn-info">
                        <i class="fas fa-print" style="font-size: 30px;"></i>
                        All
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="col">Laporan Data Produk</th>
                <td colspan="4">
                    <a href="cetakproduk.php" class="btn btn-info">
                        <i class="fas fa-print" style="font-size: 30px;"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <th scope="col">Laporan Data Konsumen</th>
                <td colspan="4">
                    <a href="cetakkonsumen.php" class="btn btn-info">
                        <i class="fas fa-print" style="font-size: 30px;"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>