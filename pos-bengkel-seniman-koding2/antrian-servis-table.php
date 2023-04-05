<?php 
  error_reporting(0);
  include '_header-artibut.php';
  $tanggalSekarang = date("Y-m-d");
?>

				<div class="screen-antrian-table">
					<div class="row">
						<div class="col-4">
							<div class="screen-antrian-table-row-title">
								Daftar Antrian
							</div>

							<?php  
								$antiranMasuk = query("SELECT * FROM data_servis WHERE ds_status = 1 && ds_cabang = $sessionCabang && ds_terima_date = '".$tanggalSekarang."' ");
							?>
							<div class="screen-antrian-table-row-desc">
								<?php foreach ( $antiranMasuk as $row ) : ?>
								<div class="small-box bg-default">
						            <div class="inner">
						                <div class="row">
						                	<div class="col-5">
						                		<div class="screen-antrian-table-no">
						                			<div class="sat-title">
						                				No. Antrian
						                			</div>
						                			<div class="satn-no">
						                				<?= $row['ds_antrian']; ?>
						                			</div>
						                		</div>
						                	</div>
						                	<div class="col-7">
						                		<div class="screen-antrian-table-teks">
						                			<div class="sat-title">
						                				Kendaraan
						                			</div>
						                			<?php  
						                				$ds_kendaraan_id = $row['ds_kendaraan_id'];
						                				$kendaraan = mysqli_query($conn, "SELECT kendaraan_nopol, kendaraan_merek, kendaraan_tipe, kendaraan_jenis FROM kendaraan WHERE kendaraan_id = $ds_kendaraan_id;");
						                				$kendaraan = mysqli_fetch_array($kendaraan); 
						                			?>
						                			<div class="satk-teks">
						                				<ul>
						                					<li>
						                					    No. Pol <?= $kendaraan['kendaraan_nopol']; ?>
						                					</li>
						                					<li>
						                					   <?= $kendaraan['kendaraan_merek']; ?> 
						                					   <?= $kendaraan['kendaraan_tipe']; ?> 
						                					   <?= $kendaraan['kendaraan_jenis']; ?>
						                					</li>
						                				</ul>
						                			</div>
						                		</div>
						                	</div>
						                </div>
						            </div>
						        </div>
						    	<?php endforeach; ?>
							</div>
						</div>
						<div class="col-4">
							<div class="screen-antrian-table-row-title">
								Proses Servis Mekanik
							</div>

							<?php  
								$antiranMasuk = query("SELECT * FROM data_servis WHERE ds_status = 4 && ds_cabang = $sessionCabang && ds_terima_date = '".$tanggalSekarang."' ORDER BY ds_id DESC");
							?>
							<div class="screen-antrian-table-row-desc">
								<?php foreach ( $antiranMasuk as $row ) : ?>
								<div class="small-box bg-info">
						            <div class="inner">
						                <div class="row">
						                	<div class="col-5">
						                		<div class="screen-antrian-table-no">
						                			<div class="sat-title">
						                				No. Antrian
						                			</div>
						                			<div class="satn-no">
						                				<?= $row['ds_antrian']; ?>
						                			</div>
						                		</div>
						                	</div>
						                	<div class="col-7">
						                		<div class="screen-antrian-table-teks">
						                			<div class="sat-title">
						                				Kendaraan
						                			</div>
						                			<?php  
						                				$ds_kendaraan_id = $row['ds_kendaraan_id'];
						                				$kendaraan = mysqli_query($conn, "SELECT kendaraan_nopol, kendaraan_merek, kendaraan_tipe, kendaraan_jenis FROM kendaraan WHERE kendaraan_id = $ds_kendaraan_id;");
						                				$kendaraan = mysqli_fetch_array($kendaraan); 
						                			?>
						                			<div class="satk-teks">
						                				<ul>
						                					<li>
						                					    No. Pol <?= $kendaraan['kendaraan_nopol']; ?>
						                					</li>
						                					<li>
						                					   <?= $kendaraan['kendaraan_merek']; ?> 
						                					   <?= $kendaraan['kendaraan_tipe']; ?> 
						                					   <?= $kendaraan['kendaraan_jenis']; ?>
						                					</li>
						                				</ul>
						                			</div>
						                		</div>
						                	</div>
						                </div>
						            </div>
						        </div>
						    	<?php endforeach; ?>
							</div>
						</div>
						<div class="col-4">
							<div class="screen-antrian-table-row-title">
								Servis Selesai
							</div>

							<?php  
								$antiranMasuk = query("SELECT * FROM data_servis WHERE ds_status = 5 && ds_cabang = $sessionCabang && ds_terima_date = '".$tanggalSekarang."' ORDER BY ds_id DESC");
							?>
							<div class="screen-antrian-table-row-desc">
								<?php foreach ( $antiranMasuk as $row ) : ?>
								<div class="small-box bg-danger">
						            <div class="inner">
						                <div class="row">
						                	<div class="col-5">
						                		<div class="screen-antrian-table-no">
						                			<div class="sat-title">
						                				No. Antrian
						                			</div>
						                			<div class="satn-no">
						                				<?= $row['ds_antrian']; ?>
						                			</div>
						                		</div>
						                	</div>
						                	<div class="col-7">
						                		<div class="screen-antrian-table-teks">
						                			<div class="sat-title">
						                				Kendaraan
						                			</div>
						                			<?php  
						                				$ds_kendaraan_id = $row['ds_kendaraan_id'];
						                				$kendaraan = mysqli_query($conn, "SELECT kendaraan_nopol, kendaraan_merek, kendaraan_tipe, kendaraan_jenis FROM kendaraan WHERE kendaraan_id = $ds_kendaraan_id;");
						                				$kendaraan = mysqli_fetch_array($kendaraan); 
						                			?>
						                			<div class="satk-teks">
						                				<ul>
						                					<li>
						                					    No. Pol <?= $kendaraan['kendaraan_nopol']; ?>
						                					</li>
						                					<li>
						                					   <?= $kendaraan['kendaraan_merek']; ?> 
						                					   <?= $kendaraan['kendaraan_tipe']; ?> 
						                					   <?= $kendaraan['kendaraan_jenis']; ?>
						                					</li>
						                				</ul>
						                			</div>
						                		</div>
						                	</div>
						                </div>
						            </div>
						        </div>
						    	<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>