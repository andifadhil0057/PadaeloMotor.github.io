<?php 
include 'aksi/functions.php';

$id = base64_decode($_GET["id"]);

if( hapusKategoriServis($id) > 0) {
	echo "
		<script>
			document.location.href = 'kategori-servis';
		</script>
	";
} else {
	echo "
		<script>
			alert('Data gagal dihapus');
			document.location.href = 'kategori-servis';
		</script>
	";
}

?>