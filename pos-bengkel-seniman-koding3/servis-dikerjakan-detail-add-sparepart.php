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

$barang = query("SELECT * FROM barang WHERE barang_id = ".$id." && barang_cabang = ".$sessionCabang." ")[0];

	$dss_nama     			= $barang['barang_nama'];
	$dss_harga_beli    		= $barang['barang_harga_beli'];
	$dss_harga    			= $barang['barang_harga'];
	$barang_id          	= $barang['barang_id'];
	$barang_kode_slug   	= $barang['barang_kode_slug'];
	$dss_qty      			= 1;
	$dss_barang_sn_id    	= 0;
	$dss_barang_option_sn 	= $barang['barang_option_sn'];
	$dss_sn       			= 0;
	$dss_id_teknisi 		= $_SESSION['user_id'];
	$dss_nota   			= $nota;
	$dss_cabang   		   	= $sessionCabang;
	$dss_cek 				= $barang_id.$dss_id_teknisi.$dss_cabang.$dss_nota;
	$barang_stock 			= $barang['barang_stock'];
	$barang_terjual 		= $barang['barang_terjual'];

	// Cek apakah data barang sudah sesuai dengan jumlah stok saat Insert Ke Keranjang dan jika melebihi stok maka akan dikembalikan
	$idBarang 		= mysqli_query($conn, "select dss_qty from data_servis_sparepart where barang_id = ".$barang_id." && dss_nota = ".$dss_nota." ");
    $idBarang 		= mysqli_fetch_array($idBarang);
   	$dss_qty_stock 	= $idBarang['dss_qty'];


   	if ( $barang['barang_stock'] < 1  ) {
   		echo '
			<script>
				alert("Sparepart TIDAK BISA DITAMBAHKAN Karena Jumlah QTY Melebihi Stock yang Ada di Semua Transaksi Servis Mohon di Cek Kembali !!!");
				document.location.href = "'.$link.'";
			</script>
		';
   	} else {
   		// Insert Data ke Table Keranjang dengan function tambahKeranjang() Lokasi di file aksi/function.php
		if( tambahBiayaSparepart($dss_nama, $dss_harga_beli, $dss_harga, $barang_id, $barang_kode_slug, $dss_qty, $dss_barang_sn_id, $dss_barang_option_sn, $dss_sn, $dss_id_teknisi, $dss_nota, $dss_cek, $barang_stock, $barang_terjual, $dss_cabang) > 0) {
			echo "
				<script>
					document.location.href = '".$link."';
				</script>
			";
		} else {
			echo "
				<script>
					alert('Data gagal di Insert');
					document.location.href = '".$link."';
				</script>
			";
		}
   	}

?>