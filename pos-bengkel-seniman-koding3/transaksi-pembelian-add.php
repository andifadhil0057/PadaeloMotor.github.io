<?php 
include '_header-artibut.php';

$id = abs((int)base64_decode($_GET["id"]));

if ( $id == null ) {
	echo '
		<script>
			document.location.href = "beli-langsung";
		</script>
	';
}

$barang = query("SELECT * FROM barang WHERE barang_id = ".$id." && barang_cabang = ".$sessionCabang." ")[0];

	$barang_id          = $barang['barang_id'];
	$keranjang_nama     = $barang['barang_nama'];
	$keranjang_harga    = 0;
	$keranjang_id_kasir = $_SESSION['user_id'];
	$keranjang_qty      = 1;
	$keranjang_cabang   = $sessionCabang;
	$keranjang_id_cek   = $barang_id.$keranjang_id_kasir.$keranjang_cabang;

	
   	// Insert Data ke Table Keranjang dengan function tambahKeranjangPembelian() Lokasi di file aksi/function.php
	if( tambahKeranjangPembelian($barang_id, $keranjang_nama, $keranjang_harga, $keranjang_id_kasir, $keranjang_qty, $keranjang_cabang, $keranjang_id_cek) > 0)
	{
		echo "
			<script>
				document.location.href = 'transaksi-pembelian';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data gagal di Insert');
				document.location.href = 'transaksi-pembelian';
			</script>
		";
   	}

?>