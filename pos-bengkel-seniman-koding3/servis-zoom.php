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
// ambil data di URL
$id = abs((int)base64_decode($_GET['id']));

// query data mahasiswa berdasarkan id
$servis = query("SELECT * FROM servis WHERE servis_id = $id ")[0];
// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){

  // cek apakah data berhasil di tambahkan atau tidak
  if( editServis($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'servis';
      </script>
    ";
  } elseif( editServis($_POST) == 0 ) {
    echo "
      <script>
        alert('Anda Belum Melakukan Perubahan Data !!');
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
            <h1>Data Servis</h1>
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
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label for="servis_kode">Barcode / Kode Servis</label>
                          <input type="text" name="servis_kode" class="form-control" id="servis_kode" value="<?= $servis['servis_kode']; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-6"></div>
                    <div class="col-md-6 col-lg-6">
                      <input type="hidden" name="servis_id" value="<?= $servis['servis_id']; ?>">
                        <div class="form-group">
                            <label for="servis_nama">Nama Servis</label>
                            <input type="text" name="servis_nama" class="form-control" id="servis_nama" value="<?= $servis['servis_nama']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="servis_desc">Deskripsi</label>
                            <textarea name="servis_desc" id="servis_desc" class="form-control" rows="5" readonly="readonly" placeholder="Deskripsi Lengkap"><?= $servis['servis_desc']; ?></textarea>
                        </div>
                        <div class="form-group ">
                            <label for="servis_kategori" class="">Kategori Servis</label>
                              <?php  
                                    $kategori = $servis['servis_kategori'];
                                    $kategoriParent = mysqli_query( $conn, "select kategori_servis_nama from kategori_servis where kategori_servis_id = ".$kategori." && kategori_servis_cabang = '".$sessionCabang."' ");
                                    $kn = mysqli_fetch_array($kategoriParent); 
                                    $nKn = $kn['kategori_servis_nama'];
                                ?>

                            <input type="text" name="servis_biaya" class="form-control" id="servis_biaya" value="<?= $nKn; ?>" readonly >
                        </div>
                        <div class="form-group">
                            <label for="servis_biaya_jasa_teknisi">Biaya Jasa Servis Teknisi</label>
                            <input type="number" name="servis_biaya_jasa_teknisi" class="form-control" id="servis_biaya_jasa_teknisi" value="<?= $servis['servis_biaya_jasa_teknisi']; ?>" onkeypress="return hanyaAngka(event)" readonly="" >
                        </div>
                        <div class="form-group">
                            <label for="servis_biaya_profit">Biaya Profit Bengkel</label>
                            <input type="number" name="servis_biaya_profit" class="form-control" id="servis_biaya_profit" value="<?= $servis['servis_biaya_profit']; ?>" onkeypress="return hanyaAngka(event)" readonly="" >
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="servis_biaya">Total Biaya</label>
                            <input type="number" name="servis_biaya" class="form-control" id="servis_biaya" value="<?= $servis['servis_biaya']; ?>" onkeypress="return hanyaAngka(event)" readonly="" >
                        </div>
                        <div class="form-group ">
                            <label for="servis_status">Status</label>

                              <?php  
                                if ( $servis['servis_status'] === '1' ) {
                                  $status = "Active";
                                } else {
                                  $status = " Not Active";
                                }
                              ?>
                              <input type="text" name="servis_biaya" class="form-control" id="servis_biaya" value="<?= $status; ?>" readonly >
                        </div>
                        <div class="form-group">
                            <label for="servis_id_user_create">User Create</label>
                            <?php  
                              $servis_id_user_create = $servis['servis_id_user_create'];
                              if ( $servis_id_user_create < 1 ) {
                                $view_servis_id_user_create = "-";
                              } else {
                                $namaCreate = mysqli_query($conn, "SELECT user_nama, user_level FROM user WHERE user_id = $servis_id_user_create ");
                                $namaCreate = mysqli_fetch_array($namaCreate);
                                $user_nama  = $namaCreate['user_nama'];
                                $user_level = ucwords($namaCreate['user_level']);

                                $view_servis_id_user_create = $user_nama." - Level ".$user_level;
                              }
                            ?>
                            <input type="text" name="servis_id_user_create" class="form-control" id="servis_id_user_create" value="<?= $view_servis_id_user_create; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="servis_date_time">Waktu Create</label>
                            <input type="text" name="servis_date_time" class="form-control" id="servis_date_time" value="<?= $servis['servis_date_time']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="servis_id_user_edit">User Edit Data</label>
                            <?php  
                              $servis_id_user_edit = $servis['servis_id_user_edit'];
                              if ( $servis_id_user_edit < 1 ) {
                                $view_servis_id_user_edit = "-";
                              } else {
                                $namaEdit = mysqli_query($conn, "SELECT user_nama, user_level FROM user WHERE user_id = $servis_id_user_edit ");
                                $namaEdit = mysqli_fetch_array($namaEdit);
                                $user_nama  = $namaEdit['user_nama'];
                                $user_level = ucwords($namaEdit['user_level']);

                                $view_servis_id_user_edit = $user_nama." - Level ".$user_level;
                              }
                            ?>
                            <input type="text" name="servis_id_user_edit" class="form-control" id="servis_id_user_edit" value="<?= $view_servis_id_user_edit; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="servis_date_time_edit">Terakhir Waktu Edit Data</label>
                            <?php  
                              $editData = $servis['servis_date_time_edit'];
                              if ( $editData == null ) {
                                $viewEditData = "-";
                              } else {
                                $viewEditData = $editData;
                              }
                            ?>
                            <input type="text" name="servis_date_time_edit" class="form-control" id="servis_date_time_edit" value="<?= $viewEditData; ?>" readonly>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-right">
                  <a href="#!" class="btn btn-success float-right" onclick="self.close()" style="margin-right: 5px;"> Kembali</a>
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

