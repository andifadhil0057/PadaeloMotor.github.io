<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>
<?php  
  if ( $levelLogin === "kasir" && $levelLogin === "kurir" ) {
    echo "
      <script>
        document.location.href = 'bo';
      </script>
    ";
  }  
?>
<?php  

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){

  // cek apakah data berhasil di tambahkan atau tidak
  if( tambahServis($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'servis';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('data gagal ditambahkan');
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
            <h1>Tambah Data Servis</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data Servis</li>
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
                <h3 class="card-title">Data Servis</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">
                <div class="card-body">
                  <div class="row">
                    <input type="hidden" name="servis_id_user_create" value="<?= $userIdLogin; ?>">
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label for="servis_kode">Barcode / Kode Servis</label>
                          <input type="text" name="servis_kode" class="form-control" id="servis_kode" placeholder="Contoh: servis-mesin" required autofocus="">
                          <small style="color: red">
                            <b>
                              Barcode / Kode Servis Sifatnya Sekali Input & Pastikan Tidak Terjadi Kesalahan
                            </b>
                          </small>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-6"></div>
                    <div class="col-md-6 col-lg-6">
                      <input type="hidden" name="servis_cabang" value="<?= $sessionCabang; ?>">
                        <div class="form-group">
                            <label for="servis_nama">Nama Servis</label>
                            <input type="text" name="servis_nama" class="form-control" id="servis_nama" placeholder="Input Nama Servis" required>
                        </div>
                        <div class="form-group">
                            <label for="servis_desc">Deskripsi</label>
                            <textarea name="servis_desc" id="servis_desc" class="form-control" rows="5" required="required" placeholder="Deskripsi Lengkap"></textarea>
                        </div>
                        <div class="form-group ">
                            <label for="servis_kategori" class="">Kategori Servis</label>
                            <div class="">
                              <?php $data = query("SELECT * FROM kategori_servis WHERE kategori_servis_cabang = $sessionCabang && kategori_servis_status > 0 ORDER BY kategori_servis_id DESC"); ?>

                              <select name="servis_kategori" required="" class="form-control ">
                                  <option value="">--Pilih Kategori--</option>
                                  <?php foreach ( $data as $row ) : ?>
                                      <option value="<?= $row['kategori_servis_id']; ?>">
                                        <?= $row['kategori_servis_nama']; ?> 
                                      </option>
                                  <?php endforeach; ?>
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="servis_biaya_jasa_teknisi">Biaya Jasa Servis Teknisi</label>
                            <input type="number" name="servis_biaya_jasa_teknisi" class="form-control" id="servis_biaya_jasa_teknisi" placeholder="Input Biaya Servis yang Didapatkan Teknisi" onkeypress="return hanyaAngka(event)" >
                        </div>
                        <div class="form-group">
                            <label for="servis_biaya_profit">Biaya Profit Bengkel</label>
                            <input type="number" name="servis_biaya_profit" class="form-control" id="servis_biaya_profit" placeholder="Input Nominal Keuntungan Bengkel" onkeypress="return hanyaAngka(event)" >
                        </div>
                        <div class="form-group ">
                            <label for="servis_status">Status</label>
                            <div class="">
                                  <select name="servis_status" required="" class="form-control ">
                                    <option value="">-- Status --</option>
                                    <option value="1">Active</option>
                                    <option value="0">Not Active</option>
                                  </select>
                            </div>
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
<script>
    function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
 
        return false;
      return true;
    }
</script>

