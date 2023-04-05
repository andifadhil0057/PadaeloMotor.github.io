<?php  
	include '_header-artibut.php';
	$id = $_GET['id'];

	// query data berdasarkan id
	$servis       = query("SELECT * FROM data_servis WHERE ds_id = $id ")[0];
	$nota         					 = $servis['ds_nota'];
	$status       					 = $servis['ds_status'];
	$ds_garansi_komplain_penerima_id = $servis['ds_garansi_komplain_penerima_id'];
	$cabangServis 					 = $servis['ds_cabang'];
?>

                      	
    <div class="form-group">
        <label for="ds_kondisi_barang">Garansi Servis</label>
        <!-- <input type="date" name="ds_garansi" class="form-control" id="ds_garansi" value="<?= $servis['ds_garansi']; ?>" required> -->
        <div class="row">
        	<div class="col-5">
        		<input type="number" name="ds_garansi_waktu_angka" class="form-control" id="ds_garansi_waktu_angka" placeholder="Contoh: 3" value="<?= $servis['ds_garansi_waktu_angka']; ?>" required>
        	</div>
        	<div class="col-7">
        		<select name="ds_garansi_waktu_teks" id="input" class="form-control" required="required">
                    <?php if ( $servis['ds_garansi_waktu_teks'] == null ) : ?>
                    <option value="">-- Pilih --</option>
                    <option value="days">Hari</option>
                    <option value="month">Bulan</option>
                    <option value="year">Tahun</option>
                    <?php else : ?>
                        <?php  
                            $ds_garansi_waktu_teks = $servis['ds_garansi_waktu_teks'];
                        ?>
                        <?php if ( $ds_garansi_waktu_teks === "days" ) : ?>
                        <option value="days">Hari</option>
                        <option value="month">Bulan</option>
                        <option value="year">Tahun</option>
                        <?php elseif ( $ds_garansi_waktu_teks === "month" ) : ?>
                        <option value="month">Bulan</option>
                        <option value="year">Tahun</option>
                        <option value="days">Hari</option>
                        <?php elseif ( $ds_garansi_waktu_teks === "year" ) : ?>
                        <option value="year">Tahun</option>
                        <option value="days">Hari</option>
                        <option value="month">Bulan</option>
                        <?php endif; ?>
                    <?php endif; ?>
        		</select>
        	</div>
        </div>
        <?php if ( $servis['ds_garansi'] != null ) { ?>
        <p style="padding-top: 5px;">
        	<?php  
        		$ds_garansi_waktu_teks = $servis['ds_garansi_waktu_teks'];
        		if ( $ds_garansi_waktu_teks === "days" ) {
        			$dgwt = "Hari";
        		} elseif ( $ds_garansi_waktu_teks === "month" ) {
        			$dgwt = "Bulan";
        		} elseif ( $ds_garansi_waktu_teks === "year" ) {
        			$dgwt = "Tahun";
        		}
        	?>
        	<small>Waktu Garansi <?= $servis['ds_garansi_waktu_angka']; ?> <?= $dgwt; ?> (<?= $servis['ds_garansi_date_time']; ?>)</small>
        </p>
        <?php } ?>
    </div>

    <input type="hidden" name="ds_id" value="<?= $servis['ds_id']; ?>">
	<input type="hidden" name="ds_nota" value="<?= $servis['ds_nota']; ?>">
	<input type="hidden" name="ds_teknisi" value="<?= $servis['ds_teknisi']; ?>">
	<input type="hidden" name="ds_cabang" value="<?= $servis['ds_cabang']; ?>">
	<input type="hidden" name="ds_penyerah_id" value="<?= $userIdLogin; ?>">
	<input type="hidden" name="ds_garansi_komplain_penerima_id" value="<?= $ds_garansi_komplain_penerima_id; ?>">
                  


    
                