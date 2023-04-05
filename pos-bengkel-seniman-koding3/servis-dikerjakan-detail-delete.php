<?php 
include 'aksi/functions.php';

$id    = abs((int)base64_decode($_GET['id']));
$link  = "servis-dikerjakan-detail?id=".$_GET['link'];
$tipe  = $_GET['tipe'];

if ( $tipe === "jasa" ) {
	if( hapusBiayaJasaServis($id) > 0) {
		echo '
			<script>
				document.location.href = "'.$link.'";
			</script>
		';
	} else {
		echo '
			<script>
				alert("Data gagal dihapus");
				document.location.href = "'.$link.'";
			</script>
		';
	}
} else {
	if( hapusBiayaSparepart($id) > 0) {
		echo '
			<script>
				document.location.href = "'.$link.'";
			</script>
		';
	} else {
		echo '
			<script>
				alert("Data gagal dihapus");
				document.location.href = "'.$link.'";
			</script>
		';
	}
}


?>