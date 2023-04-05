<?php

include "aksi/functions.php";
date_default_timezone_set('Asia/Jakarta');

$ds_id 								= $_POST['ds_id'];
$ds_garansi_komplain_penerima_id    = $_POST['ds_garansi_komplain_penerima_id'];
$ds_garansi_komplain_date 			= date("Y-m-d");
$ds_garansi_komplain_date_time		= date("d F Y g:i:s a");
$ds_status  						= 9;
$ds_garansi_komplain_note 			= $_POST['ds_garansi_komplain_note'];

$ds_nota                            = $_POST['ds_nota'];
$ds_teknisi                         = $_POST['ds_teknisi'];
$ds_cabang                          = $_POST['ds_cabang'];



	// Edit status di table data_servis
	$query = "UPDATE data_servis SET
					ds_garansi_komplain_date 			= '$ds_garansi_komplain_date',
					ds_garansi_komplain_date_time 		= '$ds_garansi_komplain_date_time',
					ds_garansi_komplain_penerima_id     = '$ds_garansi_komplain_penerima_id',
					ds_status 						    = '$ds_status',
					ds_garansi_komplain_note 			= '$ds_garansi_komplain_note'
					WHERE ds_id = '$ds_id' ";
	mysqli_query($conn, $query);


	// Cek Data  
	$cekHistory = query("SELECT * FROM history_servis_tekinis WHERE hst_nota = $ds_nota && hst_cabang = $ds_cabang ORDER BY hst_id DESC LIMIT 1 ")[0];
	$hst_status = $cekHistory['hst_status'];

	if ( $ds_status != $hst_status ) {
		// Insert ke history_servis_tekinis
		$query2 = "INSERT INTO history_servis_tekinis VALUES ('', '$ds_nota', '$ds_teknisi', '$ds_status', '$ds_garansi_komplain_date', '$ds_garansi_komplain_date_time', '$ds_cabang')";				
		mysqli_query($conn, $query2);
	} 
	

	$data['hasil'] = 'sukses';
    

echo json_encode($data);

?>
