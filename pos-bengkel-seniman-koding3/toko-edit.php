<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>

<?php  
// ambil data di URL
$id = abs((int)base64_decode($_GET['id']));
// query data mahasiswa berdasarkan id
$toko = query("SELECT * FROM toko WHERE toko_id = $id ")[0];



// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( editToko($_POST) > 0 ) {

    // Kondisi Cabang
    if ( $sessionCabang < 1 ) {
      $page = "toko";
    } else {
      $page = "bo";
    }

    echo "
      <script>
        document.location.href = '".$page."';
        alert('Data Berhasil Diupdate');
      </script>
    ";
  } elseif ( editToko($_POST) == 0 ) {
    echo "
      <script>
      alert('Anda Belum Melakukan Perubahan Data');
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
            <h1>Edit Data Bengkel</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data Bengkel</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <form role="form" action="" method="post">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-lg-12">
              <!-- general form elements -->
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Data Bengkel</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <input type="hidden" name="toko_id" value="<?= $toko['toko_id']; ?>">
                            <label for="toko_nama">Cabang</label>
                            <?php  
                              $cabang = $toko['toko_cabang'];

                              if ( $cabang == 0) {
                                $dataCabang = "Pusat";
                              } else {
                                $dataCabang = "Cabang ke ".$cabang;
                              }
                            ?>
                            <input type="text" name="toko_cabang" class="form-control" id="toko_cabang" value="<?= $dataCabang; ?>" disabled>
                          </div>
                          <div class="form-group">
                            <input type="hidden" name="toko_id" value="<?= $toko['toko_id']; ?>">
                            <label for="toko_nama">Nama Bengkel</label>
                            <input type="text" name="toko_nama" class="form-control" id="toko_nama" value="<?= $toko['toko_nama']; ?>" required>
                          </div>
                          <div class="form-group">
                            <label for="toko_kota">Kota Bengkel</label>
                            <input type="text" name="toko_kota" class="form-control" id="toko_kota" value="<?= $toko['toko_kota']; ?>" required>
                          </div>
                          <div class="form-group">
                            <label for="toko_alamat">Alamat</label>
                            <textarea name="toko_alamat" id="input" class="form-control" rows="3" required="required"><?= $toko['toko_alamat']; ?></textarea>
                          </div>
                          <div class="form-group">
                            <label for="toko_tlpn">No. Tlpn</label>
                            <input type="text" name="toko_tlpn" class="form-control" id="toko_tlpn" value="<?= $toko['toko_tlpn']; ?>" required onkeypress="return hanyaAngka(event)">
                          </div>
                      </div>

                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="toko_wa">WhatsApp</label>
                            <input type="number" name="toko_wa" class="form-control" id="toko_wa" value="<?= $toko['toko_wa']; ?>" required onkeypress="return hanyaAngka1(event)">
                          </div>
                          <div class="form-group">
                            <label for="toko_email">Email</label>
                            <input type="email" name="toko_email" class="form-control" id="toko_email" value="<?= $toko['toko_email']; ?>" required>
                          </div>
                          <input type="hidden" name="toko_ongkir" value="<?= $toko['toko_ongkir']; ?>">

                          <?php  
                              if ( $toko['toko_status'] == 1 ) {
                                $status = "Active";
                              } else {
                                $status = " Not Active";
                              }
                          ?>
                          <?php if ( $cabang > 0 ) : ?>
                          <div class="form-group ">
                              <label for="toko_status">Status</label>
                              <div class="">
                                  <select name="toko_status" required="" class="form-control ">
                                    <option value="<?= $toko['toko_status']; ?>">
                                      <?= $status; ?>
                                    </option>
                                    <?php  
                                      if ( $toko['toko_status'] == 1 ) {
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
                          <?php else : ?>
                          <input type="hidden" name="toko_status" value="<?= $toko['toko_status']; ?>">
                          <div class="form-group">
                            <label for="toko_status">Status</label>
                            <input type="text" name="" class="form-control" id="toko_status" value="<?= $status; ?>" disabled>
                          </div>
                          <?php endif; ?>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
              </div>
            </div>

            <div class="col-md-12 col-lg-12">
                <!-- general form elements -->
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title">Data Printer</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6 col-lg-6">
                          <?php  
                              if ( $toko['toko_tipe_print_toko'] == 1 ) {
                                $toko_tipe_print_toko = "Thermal";
                              } else {
                                $toko_tipe_print_toko = "Biasa";
                              }
                          ?>
                            <div class="form-group">
                              <label for="toko_tipe_print_toko">Tipe Print Toko</label>
                              <div class="">
                                    <select name="toko_tipe_print_toko" required="" class="form-control ">
                                      <option value="<?= $toko['toko_tipe_print_toko']; ?>">
                                        <?= $toko_tipe_print_toko; ?>
                                      </option>
                                      <?php  
                                        if ( $toko['toko_tipe_print_toko'] == 1 ) {
                                          echo '
                                            <option value="0">Biasa</option>
                                          ';
                                        } else {
                                          echo '
                                            <option value="1">Thermal</option>
                                          ';
                                        }
                                      ?>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="toko_lebar_print_toko">Ukuran Lebar Kertas Printer Toko (Thermal cm)</label>
                              <input type="number" name="toko_lebar_print_toko" class="form-control" id="toko_lebar_print_toko" placeholder="Contoh 8" value="<?= $toko['toko_lebar_print_toko']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                          <?php  
                              if ( $toko['toko_tipe_print_servis'] == 1 ) {
                                $toko_tipe_print_servis = "Thermal";
                              } else {
                                $toko_tipe_print_servis = "Biasa";
                              }
                          ?>
                            <div class="form-group">
                              <label for="toko_tipe_print_servis">Tipe Print Servis</label>
                              <div class="">
                                   <select name="toko_tipe_print_servis" required="" class="form-control ">
                                      <option value="<?= $toko['toko_tipe_print_servis']; ?>">
                                        <?= $toko_tipe_print_servis; ?>
                                      </option>
                                      <?php  
                                        if ( $toko['toko_tipe_print_servis'] == 1 ) {
                                          echo '
                                            <option value="0">Biasa</option>
                                          ';
                                        } else {
                                          echo '
                                            <option value="1">Thermal</option>
                                          ';
                                        }
                                      ?>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="toko_lebar_print_servis">Ukuran Lebar Kertas Printer Toko (Thermal cm)</label>
                              <input type="number" name="toko_lebar_print_servis" class="form-control" id="toko_lebar_print_servis" placeholder="Contoh 8" value="<?= $toko['toko_lebar_print_servis']; ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="toko_link">Link Domain</label>
                              <input type="text" name="toko_link" placeholder="Contoh: https://blidiwa.link" value="<?= $toko['toko_link']; ?>" class="form-control" id="toko_link" >
                              <small class="red"><b>Tambahkan Link Jika di Upload Pada Hosting & online</b></small>
                            </div>
                        </div>
                      </div>
                    </div>      
                </div>
            </div>

            <div class="col-md-12 col-lg-12">
              <!-- general form elements -->
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Tambahan Informasi Teks Nota Servis</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="toko_teks_nota_servis_masuk">Teks Nota Servis Masuk</label>
                            <textarea name="toko_teks_nota_servis_masuk" id="input" class="form-control" rows="3" required="required"><?= $toko['toko_teks_nota_servis_masuk']; ?></textarea>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="toko_teks_nota_servis_ambil">Teks Nota Servis Ambil</label>
                              <textarea name="toko_teks_nota_servis_ambil" id="input" class="form-control" rows="3" required="required"><?= $toko['toko_teks_nota_servis_ambil']; ?></textarea>
                          </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer text-right">
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                  </div>
                
              </div>
            </div>
          </div>
        </form>
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
    function hanyaAngka1(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
 
        return false;
      return true;
    }
</script>