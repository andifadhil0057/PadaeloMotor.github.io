<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>
<?php  
  if ( $levelLogin === "kurir") {
    echo "
      <script>
        document.location.href = 'bo';
      </script>
    ";
  }  
?>
<?php  

$penerimaan     = base64_decode($_GET['penerimaan']);
$customerLink   = base64_decode($_GET['customer']);
  if ( $penerimaan > 0 ) {
    $page = "servis-penerimaan-barang?kendaraan=".base64_encode(1);
  } else {
    $page = "kendaraan";
  }

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( tambahKendaraan($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = '".$page."';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('Data GAGAL Ditambahkan');
      </script>
    ";
  }
  
}
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Data Kendaraan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data Kendaraan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Kendaraan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 col-lg-4">
                      <input type="hidden" name="kendaraan_cabang" value="<?= $sessionCabang; ?>">
                        <div class="form-group">
                          <label for="kendaraan_pemilik">Nama Customer</label>
                          <select class="form-control select2bs4" required="" name="kendaraan_pemilik">
                            <?php if ( $customerLink < 1 ) { ?>
                              <option selected="selected" value="">-- Pilih Customer --</option>
                            <?php } ?>
                            
                              <?php  
                                $customer = query("SELECT * FROM customer WHERE customer_cabang = $sessionCabang && customer_status = '1' ORDER BY customer_id DESC ");
                              ?>
                              <?php foreach ( $customer as $ctr ) : ?>
                                <?php if ( $ctr['customer_id'] > 1 && $ctr['customer_nama'] !== "Customer Umum" ) { ?>
                                <option value="<?= $ctr['customer_id'] ?>">
                                    <?= $ctr['customer_nama'] ?> - WA <?= $ctr['customer_tlpn'] ?>
                                </option>
                                <?php } ?>
                              <?php endforeach; ?>
                            </select>
                            <small>
                              <a href="customer-add?kendaraan=<?= base64_encode(1); ?>&penerimaan=<?= $_GET['penerimaan']; ?>" id="tambah-kendaraan">Tambah Customer <i class="fa fa-plus"></i></a>
                            </small>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="kendaraan_nopol">No. Pol</label>
                          <input type="text" name="kendaraan_nopol" class="form-control text-uppercase" id="kendaraan_nopol" placeholder="Enter No. Pol" required>
                        </div>
                      </div>

                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="kendaraan_merek">Merek</label>
                          <input type="text" name="kendaraan_merek" class="form-control" id="kendaraan_merek" placeholder="Contoh: Honda/Daihatsu" required>
                        </div>
                      </div>

                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="kendaraan_tipe">Tipe</label>
                          <input type="text" name="kendaraan_tipe" class="form-control" id="kendaraan_tipe" placeholder="Motor: MATIC/SPORT - Mobil: MPV/SEDAN" required>
                        </div>  
                      </div>

                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="kendaraan_jenis">Jenis</label>
                          <input type="text" name="kendaraan_jenis" class="form-control" id="kendaraan_jenis" placeholder="Motor: CB150R Streetfire - Mobil: City Car" required>
                        </div>
                      </div>

                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="kendaraan_tahun_buat">Tahun Buat</label>
                          <input type="text" name="kendaraan_tahun_buat" class="form-control" id="kendaraan_tahun_buat" placeholder="Enter Tahun Buat" required>
                        </div>
                      </div>

                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="kendaraan_tahun_rakit">Tahun Rakit</label>
                          <input type="text" name="kendaraan_tahun_rakit" class="form-control" id="kendaraan_tahun_rakit" placeholder="Enter Tahun Rakit" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                          <label for="kendaraan_silinder">Silinder</label>
                          <input type="text" name="kendaraan_silinder" class="form-control" id="kendaraan_silinder" placeholder="Contoh: 6 Silinder" required>
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                          <label for="kendaraan_warna">Warna</label>
                          <input type="text" name="kendaraan_warna" class="form-control" id="kendaraan_warna" placeholder="Contoh: Merah Maroon" required>
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                          <label for="kendaraan_no_rangka">No. Rangka</label>
                          <input type="text" name="kendaraan_no_rangka" class="form-control" id="kendaraan_no_rangka" placeholder="Enter No. Rangka" required>
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                          <label for="kendaraan_no_mesin">No. Mesin</label>
                          <input type="text" name="kendaraan_no_mesin" class="form-control" id="kendaraan_no_mesin" placeholder="Enter No. Mesin" required>
                      </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                            <label for="kendaraan_keterangan">Keterangan</label>
                            <textarea name="kendaraan_keterangan" id="kendaraan_keterangan" class="form-control" required="required" placeholder="Keterangan Kendaraan"></textarea>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-right">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>


  </div>


<?php include '_footer.php'; ?>