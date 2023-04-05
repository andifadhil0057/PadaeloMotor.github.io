<?php 
include 'aksi/functions.php';

$id = base64_decode($_GET["id"]);

if( hapusServisDataNotaKeseluruhan($id) > 0) {
	echo "
		<script>
			window.location=history.go(-1);
		</script>
	";
} else {
	echo "
		<script>
			alert('Data gagal dihapus');
			window.location=history.go(-1);
		</script>
	";
}

?>