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

	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1>Data Laporan Status Servis Berdasarkan Periode</h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Status Periode</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Filter Data Berdasrkan Tanggal</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <form role="form" action="" method="POST">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control" id="tanggal_awal" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" id="tanggal_akhir" required>
                    </div>
                </div>
              </div>
              <div class="card-footer text-right">
                  <button type="submit" name="submit" class="btn btn-primary">
                    <i class="fa fa-filter"></i> Filter
                  </button>
              </div>
            </div>
          </form>
      </div>
    </section>


    <?php if( isset($_POST["submit"]) ){ ?>
        <?php  
          $tanggal_awal  = $_POST['tanggal_awal'];
          $tanggal_akhir = $_POST['tanggal_akhir'];
        ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Laporan Servis Periode dari Tanggal Awal <?= tanggal_indo($tanggal_awal); ?> sampai <?= tanggal_indo($tanggal_akhir); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-auto">
                <table id="data-laporan-status-berdasarkan-periode" class="table table-bordered table-striped table-laporan">
                  <thead>
                  <tr>
                    <th style="width: 6%;">No.</th>
                    <th>Status Servis</th>
                    <th style="text-align: center;">Transaksi</th>
                  </tr>
                  </thead>
                  <tbody>

                  <tr>
                    	<td>1</td>
                      <td><b>Servis Masuk</b> <small>(Dihitung berdasarkan tanggal masuk)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $servisMasuk = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_terima_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 1 ");
                          $servisMasuk = mysqli_num_rows($servisMasuk);
                          echo $servisMasuk." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>2</td>
                      <td><b>Menunggu Sparepart</b> <small>(Dihitung berdasarkan tanggal masuk)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $menungguSparepart = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_terima_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 2 ");
                          $menungguSparepart = mysqli_num_rows($menungguSparepart);
                          echo $menungguSparepart." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>3</td>
                      <td><b>Sparepart Datang</b> <small>(Dihitung berdasarkan tanggal masuk)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $sparepartDatang = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_terima_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 3 ");
                          $sparepartDatang = mysqli_num_rows($sparepartDatang);
                          echo $sparepartDatang." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>4</td>
                      <td><b>Proses Servis</b> <small>(Dihitung berdasarkan tanggal masuk)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $prosesServis = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_terima_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 4 ");
                          $prosesServis = mysqli_num_rows($prosesServis);
                          echo $prosesServis." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>5</td>
                      <td><b>Bisa Diambil</b> <small>(Dihitung berdasarkan tanggal masuk)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $bisaDiambil = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_terima_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 5 ");
                          $bisaDiambil = mysqli_num_rows($bisaDiambil);
                          echo $bisaDiambil." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>6</td>
                      <td><b>Sudah Diambil</b> <small>(Dihitung berdasarkan tanggal ambil)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $sudahDiambil = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_ambil_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 6 ");
                          $sudahDiambil = mysqli_num_rows($sudahDiambil);
                          echo $sudahDiambil." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>7</td>
                      <td><b>Tidak Bisa</b> <small>(Dihitung berdasarkan tanggal masuk)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $tidakBisa = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_terima_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 8 ");
                          $tidakBisa = mysqli_num_rows($tidakBisa);
                          echo $tidakBisa." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>8</td>
                      <td><b>Komplain Garansi</b> <small>(Dihitung berdasarkan tanggal komplain)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $komplainGaransi = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_garansi_komplain_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 9 ");
                          $komplainGaransi = mysqli_num_rows($komplainGaransi);
                          echo $komplainGaransi." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>9</td>
                      <td><b>Cancel</b> <small>(Dihitung berdasarkan tanggal masuk)</small></td>
                      <td style="text-align: center;">
                        <?php  
                          $cancel = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_terima_date BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' && ds_cabang = $sessionCabang && ds_status = 0 ");
                          $cancel = mysqli_num_rows($cancel);
                          echo $cancel." x";
                        ?>
                      </td>
                  </tr>
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
    <?php  } ?>
  </div>
</div>



<?php include '_footer.php'; ?>

</body>
</html>