<?php 
include '_header-artibut.php';

$id    = abs((int)base64_decode($_GET["id"]));
$link  = "servis-dikerjakan-detail?id=".$_GET['link'];
$nota  = $_GET['nota'];

if ( $id == null ) {
	echo '
		<script>
			document.location.href = "'.$link.'";
		</script>
	';
}

	$servis = query("SELECT * FROM servis WHERE servis_id = ".$id." && servis_cabang = ".$sessionCabang." ")[0];

	$servis_kategori 				= $servis['servis_kategori'];
	$servis_nama     				= $servis['servis_nama'];
	$servis_biaya_jasa_teknisi      = $servis['servis_biaya_jasa_teknisi'];
	$servis_biaya_profit 			= $servis['servis_biaya_profit'];
	$servis_biaya    				= $servis['servis_biaya'];


	$cekData = mysqli_query($conn, "SELECT * FROM data_servis_teknisi WHERE dst_id_nota = $nota && dst_id_servis = $id && dst_cabang = $sessionCabang ");
	$cekData = mysqli_num_rows($cekData);

	if ( $cekData < 1 ) {
		// Insert Data ke Table Keranjang dengan function tambahBiayaJasaServis() Lokasi di file aksi/function.php
		if( tambahBiayaJasaServis($nota, $id, $servis_kategori, $servis_nama, $servis_biaya_jasa_teknisi, $servis_biaya_profit, $servis_biaya, $sessionCabang) > 0) {
			echo '
				<script>
					document.location.href = "'.$link.'";
				</script>
			';
		} else {
			echo '
				<script>
					document.location.href = "'.$link.'";
				</script>
			';
		}
	} else {
		echo '
			<script>
				alert("Data Biaya Servis Sudah Anda Tambahkan Sebelumnya !!! Silahkan Cek Kembali");
				document.location.href = "'.$link.'";
			</script>
		';
	}


?>