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
  // var_dump($_POST);

  // $barang_kode_count_id = base64_encode($_POST['barang_id']);
  // $barang_option_sn  = $_POST['barang_option_sn'];

  // if ( $barang_option_sn > 0 ) {
  //   $url = "barang-sn?no=".$barang_kode_count_id;
  // } else {
  //   $url = "barang";
  // }

  // cek apakah data berhasil di tambahkan atau tidak
  if( tambahBarang($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'barang';
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
  
  <?php 
      $barang = mysqli_query($conn,"select * from barang where barang_cabang = ".$sessionCabang." ");
      $jmlBarang = mysqli_num_rows($barang); 

      if ( $jmlBarang < 1 ) {
          $barangCount = 1;
      } else {
          $barangCount = query("SELECT * FROM barang ORDER BY barang_id DESC LIMIT 1")[0];
          $barangCount = $barangCount['barang_kode_count'];
          $barangCount += 1;
          
      }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Data Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data Barang</li>
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
                <h3 class="card-title">Data Barang</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label for="barang_kode">Barcode / Kode Barang</label>
                          <input type="text" name="barang_kode" class="form-control" id="barang_kode" placeholder="Contoh: 878868889080" required autofocus="">
                          <small style="color: red">
                            <b>
                              Barcode / Kode Barang Sifatnya Sekali Input & Pastikan Tidak Terjadi Kesalahan
                            </b>
                          </small>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-6"></div>
                    <div class="col-md-6 col-lg-6">
                      <input type="hidden" name="barang_cabang" value="<?= $sessionCabang; ?>">
                      <input type="hidden" name="barang_kode_count" value="<?= $barangCount; ?>">
                        <div class="form-group">
                            <label for="barang_nama">Nama Barang</label>
                            <input type="text" name="barang_nama" class="form-control" id="barang_nama" placeholder="Input Nama Barang" required>
                        </div>
                        <div class="form-group">
                            <label for="barang_deskripsi">Deskripsi</label>
                            <textarea name="barang_deskripsi" id="barang_deskripsi" class="form-control" rows="6" required="required" placeholder="Deskripsi Lengkap"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="barang_harga">Harga Jual</label>
                            <input type="number" name="barang_harga" class="form-control" id="barang_harga" placeholder="Input Harga Barang" onkeypress="return hanyaAngka(event)" >
                        </div>
                        <div class="form-group ">
                            <label for="kategori_id" class="">Kategori</label>
                            <div class="">
                              <?php $data = query("SELECT * FROM kategori WHERE kategori_cabang = $sessionCabang ORDER BY kategori_id DESC"); ?>
                              <select name="kategori_id" required="" class="form-control ">
                                  <option value="">--Pilih Kategori--</option>
                                  <?php foreach ( $data as $row ) : ?>
                                    <?php if ( $row['kategori_status'] === '1' ) { ?>
                                      <option value="<?= $row['kategori_id']; ?>">
                                        <?= $row['kategori_nama']; ?> 
                                      </option>
                                    <?php } ?>
                                  <?php endforeach; ?>
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">

                        <div class="form-group ">
                              <label for="satuan_id">Satuan</label>
                              <div class="">
                                <?php $data2 = query("SELECT * FROM satuan WHERE satuan_cabang = $sessionCabang ORDER BY satuan_id DESC"); ?>
                                  <select name="satuan_id" required="" class="form-control ">
                                    <option value="">-- Satuan --</option>
                                    <?php foreach ( $data2 as $row ) : ?>
                                      <?php if ( $row['satuan_status'] === '1' ) { ?>
                                        <option value="<?= $row['satuan_id']; ?>">
                                          <?= $row['satuan_nama']; ?>
                                        </option>
                                      <?php } ?>
                                    <?php endforeach; ?>
                                  </select>
                              </div>
                        </div>

                        <div class="form-group ">
                            <label for="barang_option_sn">Non-SN or SN</label>
                            <div class="">
                                <select name="barang_option_sn" required="" id="barang_option_sn" class="form-control stock-pilihan">
                                    <option value="">-- Pilih --</option>
                                        <option value="0">Non-SN</option>
                                        <option value="1">SN</option>
                                  </select>
                              </div>
                              <small style="color: red">
                                  <b>
                                      SN (Serial Number) Hanya dikhususkan Untuk Produk yang memiliki No. SN 
                                  </b>
                              </small>
                        </div>
                      
                        <div class="form-group">
                          <label for="barang_stock">Stock</label>
                          <input type="number" name="barang_stock" class="form-control" id="barang_stock" placeholder="Input Jumlah Stock" value="0" required>
                        </div>

                        <div class="form-group">
                          <label for="barang_lokasi_rak">Lokasi Rak</label>
                          <input type="teks" name="barang_lokasi_rak" class="form-control" id="barang_lokasi_rak" placeholder="Input Lokasi Rak Barang" required>
                        </div>

                        <div class="form-group ">
                            <label for="barang_status">Status</label>
                            <div class="">
                                <select name="barang_status" required="" id="barang_status" class="form-control stock-pilihan">
                                    <option value="">-- Pilih --</option>
                                        <option value="1">Dijual</option>
                                        <option value="2">Khusus Servis</option>
                                        <option value="3">Dijual & Untuk Sevis</option>
                                        <option value="0">Tidak Dijual</option>
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

