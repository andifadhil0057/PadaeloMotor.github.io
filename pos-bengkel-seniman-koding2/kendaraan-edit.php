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
// ambil data di URL
$id = abs((int)base64_decode($_GET['id']));


// query data mahasiswa berdasarkan id
$kendaraan = query("SELECT * FROM kendaraan WHERE kendaraan_id = $id ")[0];

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( editKendaraan($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'kendaraan';
      </script>
    ";
  } elseif( editKendaraan($_POST) == null ) {
    echo "
      <script>
        alert('Anda Belum Melakukan Perubahan Data !!');
        document.location.href = '';
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
            <h1>Edit Data Kendaraan</h1>
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
                    <div class="col-md-6 col-lg-6">
                      <input type="hidden" name="kendaraan_id" value="<?= $id; ?>">
                        <div class="form-group">
                          <label for="kendaraan_pemilik">Nama Customer</label>
                          <select class="form-control select2bs4" required="" name="kendaraan_pemilik">
                              <?php  
                                $kendaraan_pemilik = $kendaraan['kendaraan_pemilik'];
                                
                                // Mencari nama customer
                                $customer_nama = mysqli_query($conn, "SELECT customer_nama FROM customer WHERE customer_id = $kendaraan_pemilik");
                                $customer_nama = mysqli_fetch_array($customer_nama);
                                $customer_nama = $customer_nama['customer_nama'];
                              ?>
                              <option selected="selected" value="<?= $kendaraan_pemilik; ?>">
                                <?= $customer_nama; ?>
                              </option>


                              <?php  
                                $customer = query("SELECT * FROM customer WHERE customer_cabang = $sessionCabang && customer_id != $kendaraan_pemilik ORDER BY customer_id DESC ");
                              ?>
                              <?php foreach ( $customer as $ctr ) : ?>
                                <?php if ( $ctr['customer_id'] > 1 && $ctr['customer_nama'] !== "Customer Umum" ) { ?>
                                <option value="<?= $ctr['customer_id'] ?>">
                                    <?= $ctr['customer_nama'] ?> - <?= $ctr['customer_tlpn'] ?>
                                </option>
                                <?php } ?>
                              <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                          <label for="kendaraan_nopol">No. Pol</label>
                          <input type="text" name="kendaraan_nopol" class="form-control" id="kendaraan_nopol" placeholder="Enter No. Pol" value="<?= $kendaraan['kendaraan_nopol']; ?>" required>
                        </div>

                        <div class="form-group">
                          <label for="kendaraan_merek">Merek</label>
                          <input type="text" name="kendaraan_merek" class="form-control" id="kendaraan_merek" placeholder="Contoh: Honda" value="<?= $kendaraan['kendaraan_merek']; ?>" required>
                        </div>

                        <div class="form-group">
                          <label for="kendaraan_tipe">Tipe</label>
                          <input type="text" name="kendaraan_tipe" class="form-control" id="kendaraan_tipe" placeholder="Contoh: CUB/MATIC/SPORT/BEBEK/VESPA" value="<?= $kendaraan['kendaraan_tipe']; ?>" required>
                        </div>  

                        <div class="form-group">
                          <label for="kendaraan_jenis">Jenis</label>
                          <input type="text" name="kendaraan_jenis" class="form-control" id="kendaraan_jenis" placeholder="Contoh: CB150R Streetfire" value="<?= $kendaraan['kendaraan_jenis']; ?>" required>
                        </div>

                        <div class="form-group">
                          <label for="kendaraan_tahun_buat">Tahun Buat</label>
                          <input type="text" name="kendaraan_tahun_buat" class="form-control" id="kendaraan_tahun_buat" placeholder="Enter Tahun Buat" value="<?= $kendaraan['kendaraan_tahun_buat']; ?>" required>
                        </div>

                        <div class="form-group">
                          <label for="kendaraan_tahun_rakit">Tahun Rakit</label>
                          <input type="text" name="kendaraan_tahun_rakit" class="form-control" id="kendaraan_tahun_rakit" placeholder="Enter Tahun Rakit" value="<?= $kendaraan['kendaraan_tahun_rakit']; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label for="kendaraan_silinder">Silinder</label>
                          <input type="text" name="kendaraan_silinder" class="form-control" id="kendaraan_silinder" placeholder="Contoh: 6 Silinder" value="<?= $kendaraan['kendaraan_silinder']; ?>" required>
                      </div>

                      <div class="form-group">
                          <label for="kendaraan_warna">Warna</label>
                          <input type="text" name="kendaraan_warna" class="form-control" id="kendaraan_warna" placeholder="Contoh: Merah Maroon" value="<?= $kendaraan['kendaraan_warna']; ?>" required>
                      </div>

                      <div class="form-group">
                          <label for="kendaraan_no_rangka">No. Rangka</label>
                          <input type="text" name="kendaraan_no_rangka" class="form-control" id="kendaraan_no_rangka" placeholder="Enter No. Rangka" value="<?= $kendaraan['kendaraan_no_rangka']; ?>" required>
                      </div>

                      <div class="form-group">
                          <label for="kendaraan_no_mesin">No. Mesin</label>
                          <input type="text" name="kendaraan_no_mesin" class="form-control" id="kendaraan_no_mesin" placeholder="Enter No. Mesin" value="<?= $kendaraan['kendaraan_no_mesin']; ?>" required>
                      </div>

                      <div class="form-group">
                            <label for="kendaraan_keterangan">Keterangan</label>
                            <textarea name="kendaraan_keterangan" id="kendaraan_keterangan" class="form-control" required="required" placeholder="Keterangan Kendaraan" style="height:123px;"><?= $kendaraan['kendaraan_keterangan']; ?></textarea>
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
