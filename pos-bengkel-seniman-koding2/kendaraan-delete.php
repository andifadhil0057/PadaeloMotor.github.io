<?php 
include '_header-artibut.php';

$id = base64_decode($_GET["id"]);

$nopol = mysqli_query($conn, "SELECT kendaraan_nopol FROM kendaraan WHERE kendaraan_id = $id ");
$nopol = mysqli_fetch_array($nopol);
$kendaraan_nopol = $nopol['kendaraan_nopol'];

$data_servis = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_kendaraan_id = $id ");
$data_servis = mysqli_num_rows($data_servis);



if ( $data_servis < 1 ) {
	if( hapusKendaraan($id) > 0) {
		echo "
			<script>
				document.location.href = 'kendaraan';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data Gagal Dihapus ');
				document.location.href = 'kendaraan';
			</script>
		";
	}
} else {
	echo "
		<script>
			alert('Kendaran dengan No. Pol ".$kendaraan_nopol." TIDAK BISA DIHAPUS karena data masih ada di data servis customer !!');
			document.location.href = 'customer';
		</script>
	";
}



?>