<?php 
  error_reporting(0);
  include '_header.php';
?>
<style>
  body:not(.sidebar-mini-md) .content-wrapper, body:not(.sidebar-mini-md) .main-footer, body:not(.sidebar-mini-md) .main-header {
    transition: margin-left .3s ease-in-out;
    margin-left: 0px;
  }
</style>

	<section class="screen-antrian">
		<div class="container-fluid">
			<?php  
				$toko = query("SELECT * FROM toko WHERE toko_cabang = $sessionCabang")[0];
			?>
			<div class="screen-antrian-header">
				<div class="screen-antrian-header-bengkel">
					<?= $toko['toko_nama']; ?>
				</div>
				<div class="screen-antrian-header-alamat">
					<?= $toko['toko_alamat']; ?>
				</div>
				<div class="screen-antrian-header-kota">
					<?= $toko['toko_kota']; ?>
				</div>
			</div>

			<div class="screen-antrian-desc">
				<div class="row">
					<div class="col-6">
						<div class="screen-antrian-desc-title">
							Antrian Servis Kendaraan
						</div>
					</div>
					<div class="col-6">
						<div class="screen-antrian-desc-date">
							<?= tanggal_indo(date("Y-m-d")); ?>
						</div>
					</div>
				</div>
			</div>

			
			<span id="screen-antrian-table"></span>
		</div>
	</section>


<?php include '_footer.php'; ?>
<script>
	$("#screen-antrian-table").load("antrian-servis-table.php");

	setInterval(function() {
      $.get('antrian-servis-table.php', function(data) {
        $('#screen-antrian-table').html(data);
      });
  }, 30000);
</script>