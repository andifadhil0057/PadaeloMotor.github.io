<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>
<?php  
  if ( $levelLogin === "kurir" ) {
    echo "
      <script>
        document.location.href = 'bo';
      </script>
    ";
  }  
?>

	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Kategori Servis</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Kategori Servis</li>
            </ol>
          </div>
          <?php if ( $levelLogin !== "teknisi" && $levelLogin !== "kasir" ) { ?>
          <div class="tambah-data">
          	<a href="kategori-servis-add" class="btn btn-primary">Tambah Data</a>
          </div>
          <?php } ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <?php  
    	$data = query("SELECT * FROM kategori_servis WHERE kategori_servis_cabang = $sessionCabang ORDER BY kategori_servis_id DESC");
    ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Kategori Servis Keseluruhan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-auto">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Kategori</th>
                    <th style="text-align: center; width: 20%;">Status</th>
                    <?php if ( $levelLogin !== "teknisi" && $levelLogin !== "kasir" ) { ?>
                    <th style="text-align: center; width: 10%;">Aksi</th>
                    <?php } ?>
                  </tr>
                  </thead>
                  <tbody>

                  <?php $i = 1; ?>
                  <?php foreach ( $data as $row ) : ?>
                  <tr>
                    	<td><?= $i; ?></td>
                    	<td><?= $row['kategori_servis_nama']; ?></td>
                      <td style="text-align: center;">
                      	<?php 
                      		if ( $row['kategori_servis_status'] === "1" ) {
                      			echo "<b>Aktif</b>";
                      		} else {
                      			echo "<b style='color: red;'>Tidak Aktif</b>";
                      		}
                      	?>		
                      </td>
                      <?php if ( $levelLogin !== "teknisi" && $levelLogin !== "kasir" ) { ?>
                      <td class="orderan-online-button">
                        <?php 
                          $id = base64_encode($row["kategori_servis_id"]); 
                          $idParent = $row["kategori_servis_id"]; 
                        ?>
                      	<a href="kategori-servis-edit?id=<?= $id; ?>" title="Edit Data">
                              <button class="btn btn-primary" type="submit">
                                 <i class="fa fa-edit"></i>
                              </button>
                        </a>

                        <?php  
                          $produk = mysqli_query($conn, "select * from servis where servis_kategori = $idParent");
                          $jmlProduk = mysqli_num_rows($produk);
                        ?>
                        <?php if ( $jmlProduk < 1 ) { ?>
                          <a href="kategori-servis-delete?id=<?= $id; ?>" onclick="return confirm('Yakin dihapus ?')" title="Delete Data">
                              <button class="btn btn-danger" type="submit" name="hapus">
                                  <i class="fa fa-trash-o"></i>
                              </button>
                          </a>
                        <?php } ?>
                        <?php if ( $jmlProduk > 0 ) { ?>
                          <a href="#!" title="Delete Data">
                              <button class="btn btn-default" type="submit" name="hapus">
                                  <i class="fa fa-trash-o"></i>
                              </button>
                          </a>
                        <?php } ?>
                      </td>
                      <?php } ?>
                  </tr>
                  <?php $i++; ?>
              	<?php endforeach; ?>
                </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>



<?php include '_footer.php'; ?>

<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>
</body>
</html>