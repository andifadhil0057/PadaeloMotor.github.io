<?php 
include '_header-artibut.php';

$id = base64_decode($_GET["id"]);

$customer = mysqli_query($conn, "SELECT customer_nama FROM customer WHERE customer_id = $id ");
$customer = mysqli_fetch_array($customer);
$customer_nama = $customer['customer_nama'];

$data_servis = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_customer_id = $id ");
$data_servis = mysqli_num_rows($data_servis);

$invoice = mysqli_query($conn, "SELECT * FROM invoice WHERE invoice_customer = $id ");
$invoice = mysqli_num_rows($invoice);

$kendaraan = mysqli_query($conn, "SELECT * FROM kendaraan WHERE kendaraan_pemilik = $id ");
$kendaraan = mysqli_num_rows($kendaraan);

$dataDeleteCustomer = $data_servis + $invoice + $kendaraan;

// Pesan Alert Jika Gagal
if ( $data_servis > 0 ) {
	if ( $invoice > 0 ) {
		$pesanServis = $data_servis." x Transaksi Servis & ";
	} else {
		$pesanServis = $data_servis." x Transaksi Servis ";
	}
} else {
	$pesanServis = "";
}

if ( $invoice > 0 ) {
	$pesanInvoice = $invoice." x Transaksi Pembelian ";
} else {
	$pesanInvoice = "";
}

if ( $kendaraan > 0 ) {
	$pesankendaraan = $kendaraan." kendaraan";
} else {
	$pesankendaraan = "";
}

if ( $dataDeleteCustomer < 1 ) {
	if( hapusCustomer($id) > 0) {
		echo "
			<script>
				document.location.href = 'customer';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data Gagal Dihapus ');
				document.location.href = 'customer';
			</script>
		";
	}
} else {
	echo "
		<script>
			alert('Customer dengan Nama ".$customer_nama." TIDAK BISA DIHAPUS karena terdapat Data ".$pesanServis.$pesanInvoice.$pesankendaraan." !!');
			document.location.href = 'customer';
		</script>
	";
}



?>