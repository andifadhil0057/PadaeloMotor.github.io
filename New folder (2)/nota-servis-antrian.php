<?php 
  include '_header-artibut.php';
  include "dist/qr/phpqrcode/qrlib.php";
?>
<?php  
  $status = $_SESSION['user_status'];
    if ( $status === '0') {
    echo"
          <script>
            alert('Akun Tidak Aktif');
            window.location='./';
          </script>";
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Nota Cetak POS SERVIS - Seniman Koding</title>
	<meta charset=utf-8>
	<meta name=description content="">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<link rel="icon" type="img/png" sizes="32x32" href="https://senimankoding.com/assets/img/favicon.png">
	<!-- Tempusdominus Bootstrap 3 -->
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap-3.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/style.css">

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

	<?php  
   	 	// ambil data di URL
    	$id = abs((int)base64_decode($_GET['id']));

    	// query data 
    	$servis = query("SELECT * FROM data_servis WHERE ds_id = $id && ds_cabang = $sessionCabang ")[0];
	  
	    $toko = query("SELECT * FROM toko WHERE toko_cabang = $sessionCabang");
	?>
	<?php foreach ( $toko as $row ) : ?>
	    <?php 
	      $toko_nama              = $row['toko_nama'];
	      $toko_kota              = $row['toko_kota'];
	      $toko_tlpn              = $row['toko_tlpn'];
	      $toko_wa                = $row['toko_wa'];
	      $toko_print             = $row['toko_lebar_print_servis']; 
	      $toko_alamat            = $row['toko_alamat'];
	      $keteranganMasuk        = $row['toko_teks_nota_servis_masuk'];
	      $keteranganAmbil        = $row['toko_teks_nota_servis_ambil'];
	      $link_cek               = $row['toko_link']; 
	      $toko_tipe_print_servis = $row['toko_tipe_print_servis'];
	    ?>
	<?php endforeach; ?>
	<?php  
  		$lebarPrint = $toko_print."cm";
	?>

	<!-- Cetak QR -->
	<?php  
	    $tempdir = "qr-img/servis/";
	    $isi_teks = $link_cek."/cek-servis?data=".base64_encode($servis['ds_cabang'])."-".base64_encode($servis['ds_nota']);
	    $namafile = date("Y-m-d")."-cabang-".$servis['ds_cabang']."-nota-".$servis['ds_nota'].".png";
	    $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
	    $ukuran = 2; //batasan 1 paling kecil, 10 paling besar
	    $padding = 0;
	                         
	    QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
	?>


	<section class="nota-no-antrian" style="width: <?= $lebarPrint; ?>;">
		<div class="nota-no-antrian-parent">
			<div class="nota-no-antrian-header">
				<div class="naht-toko">
					<?= $toko_nama; ?>
				</div>
				<div class="naht-alamat">
					<?= $toko_alamat; ?>
				</div>
				<div class="naht-kota">
					<?= $toko_kota; ?>
				</div>
			</div>

			<div class="nota-no-antrian-number">
				<div class="nnan-title">
					Nomor Antrian
				</div>
				<div class="nnan-number">
					<?= $servis['ds_antrian']; ?>
				</div>
				<div class="nnan-tipe">
					<?php 
						if ( $servis['ds_tipe_servis'] < 1 ) {
							$ds_tipe_servis = "Datang Langsung";
						} else {
							$ds_tipe_servis = "Booking Online";
						}
					?>
					<small><b>Tipe Servis: <?= $ds_tipe_servis; ?></b></small>
				</div>
				<div class="nnan-datetime">
					<?= $servis['ds_terima_date_time']; ?>
				</div>
			</div>

			<div class="nota-no-antrian-qr">
				<div class="nnaqr-title">
					Cek Servis Online
				</div>
				<div class="nnaqr-qr">
					<img src="qr-img/servis/<?= $namafile; ?>" class="img-responsive">
				</div>
			</div>

			<div class="nota-no-antrian-footer">
				<div class="nnaf-title">
					Terima Kasih
				</div>
				<div class="nnaf-web">
					Powered By www.senimankoding.com
				</div>
			</div>
		</div>
	</section>


</body>
</html>

<script>
  window.print();
</script>