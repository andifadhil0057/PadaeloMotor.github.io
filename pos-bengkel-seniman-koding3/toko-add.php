<?php 
  error_reporting(0);
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>

<?php  



// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( tambahToko($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'toko';
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

  $tokoAll = query("SELECT * FROM toko ORDER BY toko_cabang DESC LIMIT 1")[0];
  $tokoParent = $tokoAll['toko_cabang'];
  $toko = $tokoParent + 1;
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Data Bengkel</h1>
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
                        <input type="hidden" name="toko_cabang" value="<?= $toko; ?>">
                          <div class="form-group">
                            <label for="toko_nama">Nama Bengkel</label>
                            <input type="text" name="toko_nama" class="form-control" id="toko_nama"  required>
                          </div>
                          <div class="form-group">
                            <label for="toko_kota">Kota Bengkel</label>
                            <input type="text" name="toko_kota" class="form-control" id="toko_kota"  required>
                          </div>
                          <div class="form-group">
                            <label for="toko_alamat">Alamat</label>
                            <textarea name="toko_alamat" id="input" class="form-control" rows="3" required="required"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="toko_tlpn">No. Tlpn</label>
                            <input type="number" name="toko_tlpn" class="form-control" id="toko_tlpn"  required onkeypress="return hanyaAngka(event)">
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="toko_wa">WhatsApp</label>
                            <input type="number" name="toko_wa" class="form-control" id="toko_wa"  required onkeypress="return hanyaAngka1(event)">
                          </div>
                          <div class="form-group">
                            <label for="toko_email">Email</label>
                            <input type="email" name="toko_email" class="form-control" id="toko_email"  required>
                          </div>
                          <input type="hidden" name="toko_ongkir" value="0">
                          <div class="form-group ">
                              <label for="toko_status">Status</label>
                              <div class="">
                                    <select name="toko_status" required="" class="form-control ">
                                      <option value="">-- Status --</option>
                                      <option value="1">Active</option>
                                      <option value="0">Not Active</option>
                                    </select>
                              </div>
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
                  <h3 class="card-title">Data Printer</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="toko_tipe_print_toko">Tipe Print Toko</label>
                            <div class="">
                                    <select name="toko_tipe_print_toko" required="" class="form-control ">
                                      <option value="">-- Pilih --</option>
                                      <option value="1">Thermal</option>
                                      <option value="0">Biasa</option>
                                    </select>
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="toko_lebar_print_toko">Ukuran Lebar Kertas Printer Toko (Thermal cm)</label>
                            <input type="number" name="toko_lebar_print_toko" class="form-control" id="toko_lebar_print_toko" placeholder="Contoh 8" value="8" required>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="toko_tipe_print_servis">Tipe Print Servis</label>
                            <div class="">
                                    <select name="toko_tipe_print_servis" required="" class="form-control ">
                                      <option value="">-- Pilih --</option>
                                      <option value="1">Thermal</option>
                                      <option value="0">Biasa</option>
                                    </select>
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="toko_lebar_print_servis">Ukuran Lebar Kertas Printer Toko (Thermal cm)</label>
                            <input type="number" name="toko_lebar_print_servis" class="form-control" id="toko_lebar_print_servis" placeholder="Contoh 8" value="8" required>
                          </div>
                          <div class="form-group">
                            <label for="toko_link">Link Domain</label>
                            <input type="text" name="toko_link" placeholder="Contoh: https://blidiwa.link" class="form-control" id="toko_link" >
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
                            <textarea name="toko_teks_nota_servis_masuk" id="input" class="form-control" rows="3" required="required"></textarea>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="toko_teks_nota_servis_ambil">Teks Nota Servis Ambil</label>
                              <textarea name="toko_teks_nota_servis_ambil" id="input" class="form-control" rows="3" required="required"></textarea>
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