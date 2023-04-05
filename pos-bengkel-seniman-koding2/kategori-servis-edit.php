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
  
// ambil data di URL
$id = abs((int)base64_decode($_GET['id']));


// query data mahasiswa berdasarkan id
$kategori = query("SELECT * FROM kategori_servis WHERE kategori_servis_id = $id ")[0];

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( editKategoriServis($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'kategori-servis';
      </script>
    ";
  } elseif ( editKategoriServis($_POST) == 0 ) {
    echo "
      <script>
        alert('Anda Belum Melakukan Perubahan Data !!');
      </script>
    ";
  } else {
    echo "
      <script>
        alert('Data Gagal Ditambahkan');
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
            <h1>Edit Data Kategori Servis</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data Kategori Servis</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Kategori Servis</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                          <input type="hidden" name="kategori_servis_id" value="<?= $kategori['kategori_servis_id']; ?>">
                          <label for="kategori_servis_nama">Nama Kategori_servis</label>
                          <input type="text" name="kategori_servis_nama" class="form-control" id="kategori_servis_nama" value="<?= $kategori['kategori_servis_nama']; ?>" required>
                        </div>
                        <div class="form-group ">
                            <label for="kategori_servis_status">Status</label>
                            <div class="">
                              <?php  
                                if ( $kategori['kategori_servis_status'] === '1' ) {
                                  $status = "Active";
                                } else {
                                  $status = " Not Active";
                                }
                              ?>
                                <select name="kategori_servis_status" required="" class="form-control ">
                                  <option value="<?= $kategori['kategori_servis_status']; ?>"><?= $status; ?></option>
                                  <?php  
                                    if ( $kategori['kategori_servis_status'] === '1' ) {
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
                  <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>


  </div>


<?php include '_footer.php'; ?>