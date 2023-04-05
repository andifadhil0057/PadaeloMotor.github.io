<?php

include "_header-artibut.php";
date_default_timezone_set('Asia/Jakarta');

// Mencari Data NOTA
$countServis = mysqli_query($conn, "select * from data_servis where ds_cabang = ".$sessionCabang." ");
$countServis = mysqli_num_rows($countServis);
if ( $countServis < 1 ) {
    $nota 	 = 0;
} else {
    $servis = query("SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang ORDER BY ds_id DESC lIMIT 1")[0];
    $nota = $servis['ds_nota_count'];
}
$nota = $nota + 1;


// Mencari Data ANTRIAN
$tanggalSaatIni = date("Y-m-d");
$countAntrian = mysqli_query($conn, "select * from data_servis where ds_cabang = ".$sessionCabang." && ds_terima_date = '".$tanggalSaatIni."' ");
$countAntrian = mysqli_num_rows($countAntrian);
if ( $countAntrian < 1 ) {
    $antrian = 0;
} else {
    $servisAntrian = query("SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang ORDER BY ds_id DESC lIMIT 1")[0];
    $antrian = $servisAntrian['ds_antrian'];
}
$antrian = $antrian + 1;




$ds_nota_count 						= $nota;
$ds_antrian							= $antrian;
$ds_customer_id_kendaraan_id 		= htmlspecialchars($_POST['ds_customer_id_kendaraan_id']);
$pecah_data    						= explode("-",$ds_customer_id_kendaraan_id);
$ds_customer_id        				= $pecah_data[0];
$ds_kendaraan_id          			= $pecah_data[1];
$ds_kendaraan_km          			= htmlspecialchars($_POST['ds_kendaraan_km']);
$ds_kendaraan_km 					= str_replace(".", "", $ds_kendaraan_km);
$ds_kategori_jenis_barang_servis_id = htmlspecialchars($_POST['ds_kategori_jenis_barang_servis_id']);
$ds_kerusakan 						= htmlspecialchars($_POST['ds_kerusakan']);
$ds_kondisi_unit_masuk 				= htmlspecialchars($_POST['ds_kondisi_unit_masuk']);
$ds_keterangan 						= htmlspecialchars($_POST['ds_keterangan']);
$ds_dp 								= htmlspecialchars($_POST['ds_dp']);
$ds_penerima_id 					= htmlspecialchars($_POST['ds_penerima_id']);
$ds_terima_date 					= date("Y-m-d");
$ds_terima_date_time 				= date("d F Y g:i:s a");
$ds_tipe_servis 					= htmlspecialchars($_POST['ds_tipe_servis']);
$ds_cabang 							= htmlspecialchars($_POST['ds_cabang']);

$countNota = mysqli_query($conn, "SELECT ds_nota_count FROM data_servis WHERE ds_nota_count = $ds_nota_count && ds_cabang = $ds_cabang ");
$countNota = mysqli_num_rows($countNota);

	if ( $countNota < 1 ) {
		$query = "insert INTO data_servis SET
					ds_nota 							= '$ds_nota_count',
					ds_nota_count 						= '$ds_nota_count',
					ds_antrian 							= '$ds_antrian',
					ds_customer_id 						= '$ds_customer_id',
					ds_kendaraan_id 					= '$ds_kendaraan_id',
					ds_kendaraan_km 					= '$ds_kendaraan_km',
					ds_kategori_jenis_barang_servis_id  = '$ds_kategori_jenis_barang_servis_id',
					ds_kerusakan 						= '$ds_kerusakan',
					ds_kondisi_unit_masuk               = '$ds_kondisi_unit_masuk',
					ds_keterangan 						= '$ds_keterangan',
					ds_dp 								= '$ds_dp',
					ds_penerima_id 						= '$ds_penerima_id',
					ds_terima_date 						= '$ds_terima_date',
					ds_terima_date_time 				= '$ds_terima_date_time',
					ds_kondisi_barang 					= '',
					ds_note 							= '',
					ds_tipe_servis 						= '$ds_tipe_servis',
					ds_total_biaya_jasa 				= '',
					ds_total_biaya_sparepart 			= '',
					ds_total_biaya_sparepart_beli       = '',
					ds_total 							= '',
					ds_total_sisa_bayar 				= '',
					ds_teknisi 							= '',
					ds_teknisi_disarankan               = '',
					ds_penyerah_id 						= '',
					ds_ambil_date 						= '-',
					ds_ambil_date_time 					= '-',
					ds_status 							= '1',
					ds_garansi 							= '',
					ds_garansi_date_time 				= '',
					ds_garansi_waktu_angka			    = '',
					ds_garansi_waktu_teks               = '',
					ds_servis_berkala 					= '',
					ds_servis_berkala_date_time         = '',
					ds_servis_berkala_waktu_angka       = '',
					ds_servis_berkala_waktu_teks        = '',
					ds_servis_berkala_teks_wa           = '-',
					ds_servis_berkala_status            = '0',
					ds_garansi_komplain_date 			= '',
					ds_garansi_komplain_date_time 		= '',
					ds_garansi_komplain_penerima_id 	= '',
					ds_garansi_komplain_note 			= '',
					ds_cabang 							= '$ds_cabang'
				";

		mysqli_query($conn, $query)
		or die ("Gagal Perintah SQL".mysql_error());
		
    	$data['hasil'] = 'sukses';
    } else {
    	$data['hasil'] = 'gagal';
    }
    

echo json_encode($data);

?>
