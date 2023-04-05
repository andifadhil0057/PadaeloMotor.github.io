<?php  
	include '_header-artibut.php';
	$id = $_GET['id'];

	// query data berdasarkan id
	$servis       = query("SELECT * FROM data_servis WHERE ds_id = $id ")[0];
	$nota         = $servis['ds_nota'];
	$ds_teknisi   = $servis['ds_teknisi'];
	$cabangServis = $servis['ds_cabang'];
?>

				<input type="hidden" name="ds_id" value="<?= $id; ?>">
				<input type="hidden" name="ds_nota" value="<?= $nota; ?>">
				<input type="hidden" name="ds_teknisi" value="<?= $ds_teknisi; ?>">
				<input type="hidden" name="ds_garansi_komplain_penerima_id" value="<?= $userIdLogin; ?>">
				<input type="hidden" name="ds_cabang" value="<?= $cabangServis; ?>">
				<div class="card-body">
                  	<div class="row">
                      	<div class="col-md-6 col-lg-6">
                          	<div class="form-group">
                              	<label for="ds_garansi_komplain_note">Keluhan Komplain Garansi Servis</label>
                             	 <textarea name="ds_garansi_komplain_note" id="ds_garansi_komplain_note" class="form-control"  rows="4" required=""><?= $servis['ds_garansi_komplain_note']; ?></textarea>
                          	</div>
                      	</div>
                    </div>  
                </div>