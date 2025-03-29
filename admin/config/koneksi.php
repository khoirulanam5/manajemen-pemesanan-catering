
<?php
function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
function do_formal_date($date='',$delimiter = '',$is_day=false)
	{
		if (empty($date)) 
		{
			$date = date('d M Y');
		}

		if (!empty($date)) 
		{
			$day = '';
			if ($is_day) 
			{
				$days = ['Saturday' => 'Sabtu',
						 'Sunday' 	=> 'Minggu', 
						 'Monday' 	=> 'Senin', 
						 'Tuesday'  => 'Selasa', 
						 'Wednesday'=> 'Rabu', 
						 'Thursday' => 'Kamis',
						 'Friday' 	=> 'Jum\'at'];
				$day = $days[date('l', strtotime($date))].', ';
			}
			$months =['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
			$d = date('d', strtotime($date));
			$m = date('m', strtotime($date));
			$y = date('Y', strtotime($date));

			$delimiter = !empty($delimiter) ? $delimiter : ' ';
			return $day.$d.$delimiter.$months[intval($m)].$delimiter.$y;
		}
	}
date_default_timezone_set('Asia/Jakarta');
$koneksi = new mysqli("localhost", "root", "", "db_catering");

$home = "http://localhost/catering/";
?>

