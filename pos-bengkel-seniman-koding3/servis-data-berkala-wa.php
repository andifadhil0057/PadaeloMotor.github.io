<?php 
include '_header-artibut.php';

$id = base64_decode($_GET["id"]);


// Mencari ID Customer
$data_servis = mysqli_query($conn, "SELECT ds_customer_id, ds_servis_berkala_date_time, ds_servis_berkala_teks_wa FROM data_servis WHERE ds_id = $id && ds_cabang = $sessionCabang ");
$data_servis = mysqli_fetch_array($data_servis);
$ds_customer_id 			 = $data_servis['ds_customer_id'];
$ds_servis_berkala_date_time = $data_servis['ds_servis_berkala_date_time'];
$ds_servis_berkala_teks_wa   = $data_servis['ds_servis_berkala_teks_wa'];

// Mencari No WA Customer
$customer = mysqli_query($conn, "SELECT customer_nama, customer_tlpn FROM customer WHERE customer_id = $ds_customer_id && customer_cabang = $sessionCabang ");
$customer = mysqli_fetch_array($customer);
$customer_nama = $customer['customer_nama'];
$customer_tlpn = $customer['customer_tlpn'];
$customer_tlpn = substr_replace($customer_tlpn,'62',0,1);

$pesanWA = "Hallo ".$customer_nama." Kami Dari *".$dataTokoLogin['toko_nama']."* menginfokan ".$ds_servis_berkala_teks_wa." Pada Tanggal ".$ds_servis_berkala_date_time;

$link = "https://api.whatsapp.com/send?phone=".$customer_tlpn."&text=".$pesanWA." ";


if( editStatusServisBerkala($id) > 0) {
	header("location: ".$link."");

} elseif ( editStatusServisBerkala($id) == 0 ) {
	echo "
		<script>
			alert('Notifikasi Hanya Bisa Dilakukan 1x !!');
			document.location.href = 'servis-data-berkala';
		</script>
	";
} else {
	echo "
		<script>
			alert('Data gagal notifikasi');
			document.location.href = 'servis-data-berkala';
		</script>
	";
}

?>