<?php

include "aksi/koneksi.php";
date_default_timezone_set('Asia/Jakarta');

$ds_id 								= $_POST['ds_id'];
$ds_penyerah_id                     = $_POST['ds_penyerah_id'];
$ds_ambil_date 						= date("Y-m-d");
$ds_ambil_date_time					= date("d F Y g:i:s a");
$ds_status  						= 6;
$ds_garansi_komplain_penerima_id    = $_POST['ds_garansi_komplain_penerima_id'];

$ds_garansi_waktu_angka				= $_POST['ds_garansi_waktu_angka'];
$ds_garansi_waktu_teks 				= $_POST['ds_garansi_waktu_teks'];

$tgl1 = date('Y-m-d');
if ( $ds_garansi_waktu_teks === "days" ) { 
	$ds_garansi = date('Y-m-d', strtotime('+'.$ds_garansi_waktu_angka.' '.$ds_garansi_waktu_teks, strtotime( $tgl1 ))); 
} elseif ( $ds_garansi_waktu_teks === "month" ) { 
	$ds_garansi = date('Y-m-d', strtotime('+'.$ds_garansi_waktu_angka.' '.$ds_garansi_waktu_teks, strtotime( $tgl1 ))); 
} elseif ( $ds_garansi_waktu_teks === "year" ) { 
	$ds_garansi = date('Y-m-d', strtotime('+'.$ds_garansi_waktu_angka.' '.$ds_garansi_waktu_teks, strtotime( $tgl1 ))); 
}


$ds_garansi 					    = $ds_garansi;
$pecah_data 				        = explode("-",$ds_garansi);
$ds_garansi_date_time_tgl 			= $pecah_data[2];
$ds_garansi_date_time_bln 			= $pecah_data[1];
if ( $ds_garansi_date_time_bln == 1 ) {
	$ds_garansi_date_time_bln = 'January';
} elseif ( $ds_garansi_date_time_bln == 2 ) {
	$ds_garansi_date_time_bln = 'February';
} elseif ( $ds_garansi_date_time_bln == 3 ) {
	$ds_garansi_date_time_bln = 'March';
} elseif ( $ds_garansi_date_time_bln == 4 ) {
	$ds_garansi_date_time_bln = 'April';
} elseif ( $ds_garansi_date_time_bln == 5 ) {
	$ds_garansi_date_time_bln = 'May';
} elseif ( $ds_garansi_date_time_bln == 6 ) {
	$ds_garansi_date_time_bln = 'June';
} elseif ( $ds_garansi_date_time_bln == 7 ) {
	$ds_garansi_date_time_bln = 'July';
} elseif ( $ds_garansi_date_time_bln == 8 ) {
	$ds_garansi_date_time_bln = 'August';
} elseif ( $ds_garansi_date_time_bln == 9 ) {
	$ds_garansi_date_time_bln = 'September';
} elseif ( $ds_garansi_date_time_bln == 10 ) {
	$ds_garansi_date_time_bln = 'October';
} elseif ( $ds_garansi_date_time_bln == 11 ) {
	$ds_garansi_date_time_bln = 'November';
} elseif ( $ds_garansi_date_time_bln == 12 ) {
	$ds_garansi_date_time_bln = 'December';
}
$ds_garansi_date_time_thn 			= $pecah_data[0];

$ds_garansi_date_time               = $ds_garansi_date_time_tgl." ".$ds_garansi_date_time_bln." ".$ds_garansi_date_time_thn;
$ds_nota                            = $_POST['ds_nota'];
$ds_teknisi                         = $_POST['ds_teknisi'];
$ds_cabang                          = $_POST['ds_cabang'];



	// Edit status di table data_servis
	$query = "UPDATE data_servis SET
					ds_penyerah_id 					= '$ds_penyerah_id',
					ds_ambil_date 					= '$ds_ambil_date',
					ds_ambil_date_time 				= '$ds_ambil_date_time',
					ds_status 						= '$ds_status',
					ds_garansi 						= '$ds_garansi',
					ds_garansi_date_time 			= '$ds_garansi_date_time',
					ds_garansi_waktu_angka 			= '$ds_garansi_waktu_angka',
					ds_garansi_waktu_teks			= '$ds_garansi_waktu_teks'
					WHERE ds_id = '$ds_id' ";
	mysqli_query($conn, $query);

	// Cek Data History
	$countHistory = mysqli_query($conn, "SELECT * FROM history_servis_tekinis WHERE hst_nota = $ds_nota && hst_status = $ds_status && hst_date_time = '".$ds_ambil_date_time."' && hst_cabang = $ds_cabang  ");
	$countHistory = mysqli_num_rows($countHistory);

	if ( $countHistory < 1 ) {
		// Insert ke history_servis_tekinis
		$query2 = "INSERT INTO history_servis_tekinis VALUES ('', '$ds_nota', '$ds_teknisi', '$ds_status', '$ds_ambil_date', '$ds_ambil_date_time', '$ds_cabang')";				
		mysqli_query($conn, $query2);
	} 


	if ( $ds_garansi_komplain_penerima_id < 1 ) {
		// Cek Data Tabel Jasa Servis
		$jasa = mysqli_query($conn, "SELECT * FROM data_servis_teknisi WHERE dst_id_nota = $ds_nota && dst_cabang = $ds_cabang  ");
		$jasaCount = mysqli_num_rows($jasa);


		if ( $jasaCount > 0 ) {
			// Insert ke history_servis_tekinis

			
			$jam = date('Y-m-d');

			$query3 = "UPDATE data_servis_teknisi SET 
								dst_pengambilan_date     = '$jam'
								WHERE dst_id_nota = $ds_nota && dst_cabang = $ds_cabang
			";
				
			mysqli_query($conn, $query3);
		} 
	}
	

	$data['hasil'] = 'sukses';
    

echo json_encode($data);

?>
