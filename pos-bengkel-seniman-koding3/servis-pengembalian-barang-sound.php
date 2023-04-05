<?php 
  include '_header-artibut.php';
  $hariIni = date("Y-m-d");
  $id      = $_POST['id'];

  $data = query("SELECT * FROM data_servis WHERE ds_id = $id && ds_cabang = $sessionCabang ")[0];
  $ds_antrian 		= $data['ds_antrian'];
  $ds_terima_date 	= $data['ds_terima_date'];
  $ds_customer_id   = $data['ds_customer_id'];

  // Mencari No WA Customer
	$customer = mysqli_query($conn, "SELECT customer_nama, customer_tlpn FROM customer WHERE customer_id = $ds_customer_id && customer_cabang = $sessionCabang ");
	$customer = mysqli_fetch_array($customer);
	$customer_nama = $customer['customer_nama'];
	$customer_tlpn = $customer['customer_tlpn'];
	$customer_tlpn = substr_replace($customer_tlpn,'62',0,1);

	$pesanWA       = "Hallo ".$customer_nama.", No. Antrian ".$ds_antrian." Silahkan Menuju Kasir !! Pesan Dari ".$dataTokoLogin['toko_nama'];
	$link = "https://api.whatsapp.com/send?phone=".$customer_tlpn."&text=".$pesanWA." ";
?>
	<?php if ( $ds_terima_date === $hariIni ) : ?>
	<div class="form-group">
        <label for="">Pemberitahuan Customer</label>
        <div class="cetak-nota-servis-wa">
        	<audio id="myAudio"><source src="sound/<?= $ds_antrian; ?>.mp3" type="audio/ogg"></audio>
        	<a href="#!">
        		<button type="" onclick="playAudio()" class="btn btn-danger">
        		Panggil Sekarang &nbsp;<i class="fa fa-play" aria-hidden="true"></i>
        		</button>
        	</a>
        	<a href="<?= $link; ?>" target="_blank">
        		<button class="btn btn-success">
        		Hubungi Sekarang &nbsp;<i class="fa fa-whatsapp" aria-hidden="true"></i>
        		</button>
        	</a>
        </div>
    </div>
	<?php else: ?>
		<p>
			Panggilan Suara TIDAK BISA Untuk NO. Antrian ini Karena kendaraan servis sudah masuk dari tanggal <?= tanggal_indo($ds_terima_date); ?>, dan Fitur Panggilan Antrian hanya bisa digunakan untuk kendaraan servis yang servis dihari ini.
		</p>
	<?php endif; ?>

	<script>
		var x = document.getElementById("myAudio"); 
		function playAudio() { 
			x.play(); 
		} 
	</script>