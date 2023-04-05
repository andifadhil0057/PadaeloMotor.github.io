<?php  
	include '_header-artibut.php';
    $kendaraan = $_GET['kendaraan'];
?>
				<div class="row">
                    <input type="hidden" name="ds_cabang" value="<?= $sessionCabang; ?>">
                    <input type="hidden" name="ds_penerima_id" value="<?= $_SESSION['user_id']; ?>">
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_customer_id">No. Polisi <span class="red">*</span></label>
                            <select class="form-control select2bs3" required="" name="ds_customer_id_kendaraan_id" id="ds_customer_id">
                            <?php if ( $kendaraan < 1 ) { ?>
                              <option selected="selected" value="">-- Pilih --</option>
                            <?php } ?>

                              <?php  
                                $kendaraan = query("SELECT * FROM kendaraan WHERE kendaraan_cabang = $sessionCabang ORDER BY kendaraan_id DESC ");
                              ?>
                              <?php foreach ( $kendaraan as $ctr ) : ?>
                                <?php 
                                    $customer_id = $ctr['kendaraan_pemilik']; 
                                    $nama_customer = mysqli_query($conn, "SELECT customer_nama FROM customer WHERE customer_id = $customer_id ");
                                    $nama_customer = mysqli_fetch_array($nama_customer);
                                    $nama_customer = $nama_customer['customer_nama'];
                                ?>
                                <option value="<?= $ctr['kendaraan_pemilik'] ?>-<?= $ctr['kendaraan_id'] ?>"><?= $ctr['kendaraan_nopol'] ?> - <?= $nama_customer; ?></option>
                               
                              <?php endforeach; ?>
                            </select>
                            <small>
                              <a href="#!" id="tambah-kendaraan">Tambah Kendaraan <i class="fa fa-plus"></i></a>
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_kategori_jenis_barang_servis_id">Kategori Servis <span class="red">*</span></label>
                            <select class="form-control select2bs4" required="" name="ds_kategori_jenis_barang_servis_id">
                              <option selected="selected" value="">-- Pilih --</option>
                              <?php  
                                $kategori_servis = query("SELECT * FROM kategori_servis WHERE kategori_servis_cabang = $sessionCabang && kategori_servis_status > 0 ORDER BY kategori_servis_id DESC ");
                              ?>
                              <?php foreach ( $kategori_servis as $row ) : ?>
                                <option value="<?= $row['kategori_servis_id'] ?>"><?= $row['kategori_servis_nama'] ?></option>
                              <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_kerusakan">Kerusakan <span class="red">*</span></label>
                            <input type="text" name="ds_kerusakan" class="form-control" id="ds_kerusakan" placeholder="Input Kerusakan Kendaraan" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_keterangan">Keterangan/Keluhan <span class="red">*</span></label>
                            <textarea name="ds_keterangan" id="textarea" class="form-control" rows="3" placeholder="Keterangan dari customer tentang keluhan Kendaraan" required=""></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_kondisi_unit_masuk">Kondisi Kendaraan Masuk <span class="red">*</span></label>
                            <input type="text" name="ds_kondisi_unit_masuk" class="form-control" id="ds_kondisi_unit_masuk" placeholder="Contoh: Kondisi Nyala" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_kendaraan_km">KM Sekarang </label>
                            <input type="number" name="ds_kendaraan_km" class="form-control" id="ds_kendaraan_km" placeholder="Input KM Kendaraan">
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_tipe_servis">Tipe Servis <span class="red">*</span></label>
                            <select name="ds_tipe_servis" id="" class="form-control" required="required">
                                <option value="">-- Pilih --</option>
                                <option value="0">Datang Langsung Ke Bengkel</option>
                                <option value="1">Booking Online</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_dp">DP</label>
                            <input type="number" name="ds_dp" class="form-control" id="ds_dp" placeholder="Input DP Servis">
                        </div>
                    </div>
                </div>

<script>
	$(function () {

        //Initialize Select2 Elements
        $('.select2bs3').select2({
          theme: 'bootstrap4'
        })
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })
        $('.select2bs5').select2({
          theme: 'bootstrap4'
        })
    });

    // Memanggil input modal tipe customer
    $(document).ready(function(){
      $("#tambah-kendaraan").click(function(){
          $("#modal-id-input").modal('show');
          $("#modal-id").modal('hide');
   
      });
    });
</script>