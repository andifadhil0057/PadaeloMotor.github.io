<?php 
include 'aksi/functions.php';

$id   = base64_decode($_GET["id"]);
$link = "servis-penerimaan-barang?kendaraan=".base64_encode(0);

if( hapusPenerimaanServis($id) > 0) {
	echo "
		<script>
			document.location.href = '".$link."';
		</script>
	";
} else {
	echo "
		<script>
			alert('Data gagal dihapus');
			document.location.href = '".$link."';
		</script>
	";
}

?>