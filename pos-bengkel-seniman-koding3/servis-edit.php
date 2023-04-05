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
            <h1>Edit Data Servis</h1>
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
                          <input type="text" name="servis_kode" class="form-control" id="servis_kode" value="<?= $servis['servis_kode']; ?>" required readonly>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-6"></div>
                    <div class="col-md-6 col-lg-6">
                      <input type="hidden" name="servis_id" value="<?= $servis['servis_id']; ?>">
                      <input type="hidden" name="servis_id_user_edit" value="<?= $userIdLogin; ?>">
                        <div class="form-group">
                            <label for="servis_nama">Nama Servis</label>
                            <input type="text" name="servis_nama" class="form-control" id="servis_nama" value="<?= $servis['servis_nama']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="servis_desc">Deskripsi</label>
                            <textarea name="servis_desc" id="servis_desc" class="form-control" rows="5" required="required" placeholder="Deskripsi Lengkap"><?= $servis['servis_desc']; ?></textarea>
                        </div>
                        <div class="form-group ">
                            <label for="servis_kategori" class="">Kategori Servis</label>
                            <div class="">
                              <?php  
                                    $kategori = $servis['servis_kategori'];
                                    $kategoriParent = mysqli_query( $conn, "select kategori_servis_nama from kategori_servis where kategori_servis_id = ".$kategori." && kategori_servis_cabang = '".$sessionCabang."' ");
                                    $kn = mysqli_fetch_array($kategoriParent); 
                                    $nKn = $kn['kategori_servis_nama'];
                                ?>
                              <select name="servis_kategori" required="" class="form-control ">
                                  <option value="<?= $kategori; ?>"><?= $nKn; ?></option>

                                  <?php $data = query("SELECT * FROM kategori_servis WHERE  kategori_servis_status > 0 && kategori_servis_cabang = $sessionCabang ORDER BY kategori_servis_id DESC"); ?>
                                  <?php foreach ( $data as $row ) : ?>
                                    <?php if ( $row['kategori_servis_id'] !== $servis['servis_kategori'] ) { ?>
                                      <option value="<?= $row['kategori_servis_id']; ?>">
                                        <?= $row['kategori_servis_nama']; ?> 
                                      </option>
                                    <?php } ?>
                                  <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="servis_biaya_jasa_teknisi">Biaya Jasa Servis Teknisi</label>
                            <input type="number" name="servis_biaya_jasa_teknisi" class="form-control" id="servis_biaya_jasa_teknisi" value="<?= $servis['servis_biaya_jasa_teknisi']; ?>" onkeypress="return hanyaAngka(event)" require="" >
                        </div>
                        <div class="form-group">
                            <label for="servis_biaya_profit">Biaya Profit Bengkel</label>
                            <input type="number" name="servis_biaya_profit" class="form-control" id="servis_biaya_profit" value="<?= $servis['servis_biaya_profit']; ?>" onkeypress="return hanyaAngka(event)" require="" >
                        </div>

                        <div class="form-group ">
                            <label for="servis_status">Status</label>
                            <div class="">
                              <?php  
                                if ( $servis['servis_status'] === '1' ) {
                                  $status = "Active";
                                } else {
                                  $status = " Not Active";
                                }
                              ?>
                                <select name="servis_status" required="" class="form-control ">
                                  <option value="<?= $servis['servis_status']; ?>"><?= $status; ?></option>
                                  <?php  
                                    if ( $servis['servis_status'] === '1' ) {
                                      echo '
                                        <option value="0">Not Active</option>
                                      ';
                                    } else {
                                      echo '
                                        <option value="1">Active</option>
                                      ';
                                    }
                                  ?>
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

