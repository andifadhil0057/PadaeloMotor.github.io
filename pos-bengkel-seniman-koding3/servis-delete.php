<?php 
include '_header-artibut.php';

$id = base64_decode($_GET["id"]);

$servis = mysqli_query($conn, "SELECT * FROM data_servis_teknisi WHERE dst_id_servis = $id && dst_cabang = $sessionCabang ");
$jmlServis = mysqli_num_rows($servis);

if ( $jmlServis < 1 ) {
	if( hapusServis($id) > 0) {
		echo "
			<script>
				document.location.href = 'servis';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data gagal dihapus');
				document.location.href = 'servis';
			</script>
		";
	}
} else {
	echo "
		<script>
			alert('Data tidak bisa dihapus karena masih ada di data servis !!');
			document.location.href = 'servis';
		</script>
	";
}

?>