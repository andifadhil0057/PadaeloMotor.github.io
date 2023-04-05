<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>

<?php  
  if ( $levelLogin !== "super admin" ) {
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
$cabang = $_GET['cabang'];


// query data mahasiswa berdasarkan id
$user = query("SELECT * FROM user WHERE user_id = $id ")[0];

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( editUserPayroll($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'users?cabang=".$cabang."';
      </script>
    ";
  } elseif( editUserPayroll($_POST) == 0 ) {
    echo "
      <script>
        alert('Anda Belum Melakukan Perubahan Data !!');
      </script>
    ";
  } else {
    echo "
      <script>
        alert('Data Gagal Diedit !!');
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
            <h1>Edit Data User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data User</li>
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
                <h3 class="card-title">Data User Edit</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">
                <div class="card-body">
                  <div class="row">
                    <input type="hidden" name="user_id" value="<?= $user["user_id"]; ?>">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="user_nama">Nama Lengkap</label>
                          <input type="text" name="user_nama" class="form-control" id="user_nama" value="<?= $user['user_nama']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_no_hp">No. Hp</label>
                            <input type="text" name="user_no_hp" class="form-control" id="user_no_hp" value="<?= $user['user_no_hp']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_alamat">Alamat</label>
                            <textarea name="user_alamat" id="user_alamat" class="form-control" rows="5" readonly="readonly"><?= $user['user_alamat']; ?></textarea>
                        </div>

                        <div class="form-group ">
                            <label for="user_level" class="">Level</label>
                            <div class="">
                              <?php  
                                if ( $user['user_level'] === "super admin" ) {
                                  $level = "Super Admin";
                                } elseif ( $user['user_level'] === "admin" ) {
                                  $level = "Admin";
                                } elseif ( $user['user_level'] === "kurir" ) {
                                  $level = "Kurir";
                                } elseif ( $user['user_level'] === "teknisi" ) {
                                  $level = "Teknisi";
                                } else {
                                  $level = "Kasir";
                                }
                              ?>
                            <input type="text" name="" class="form-control" id="" value="<?= $level; ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group ">
                              <label for="user_status">Status</label>
                              <div class="">
                                <?php  
                                  if ( $user['user_status'] === "1" ) {
                                    $status = "Aktif";
                                  } else {
                                    $status = "Tidak Aktif";
                                  }
                                ?>
                                   <input type="text" name="" class="form-control" id="" value="<?= $status; ?>" readonly>
                              </div>
                          </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="user_gaji_pokok">Gaji Pokok</label>
                          <input type="text" name="user_gaji_pokok" class="form-control" id="user_gaji_pokok" value="<?= number_format($user['user_gaji_pokok'], 0, ',', '.'); ?>" placeholder="Contoh: 2000000">
                        </div>
                        <div class="form-group">
                          <label for="user_bonus">Bonus Bulan <?= date("F Y"); ?></label>
                          <input type="text" name="user_bonus" class="form-control" id="user_bonus" value="<?= number_format($user['user_bonus'], 0, ',', '.'); ?>" placeholder="Contoh: 100000">
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
<script>
     /* Tanpa Rupiah */
    var user_gaji_pokok = document.getElementById('user_gaji_pokok');
    var user_bonus      = document.getElementById('user_bonus');

    user_gaji_pokok.addEventListener('keyup', function(e)
    {
        user_gaji_pokok.value = formatRupiah(this.value);
    });

    user_bonus.addEventListener('keyup', function(e)
    {
        user_bonus.value = formatRupiah(this.value);
    });
    
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>