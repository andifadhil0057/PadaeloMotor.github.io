<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>
<?php  
  if(empty($_GET['status'])){
    $ds_status = 4;
  } else {
    $ds_status = abs((int)base64_decode($_GET['status']));
  }
  

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
          <div class="col-sm-8">
            <?php 
              $statusServisHistory = $ds_status;
              include "_status-servis.php"; 
            ?>
            <h1>Laporan Berdasarkan Servis Status <?= $sshView; ?></h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Status Servis</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <div class="row">
                  <div class="col-md-6 col-lg-6">
                      <h3 class="card-title card-title-user">Data Servis Berdasarkan Status</h3>
                  </div>
                  <div class="col-md-6 col-lg-6">
                      <div class="box-user-select">
                          <span class="red">Pilih Status: </span>
                          <span>
                              <select class="form-control" id="mySelect" onchange="myFunction()">
                                  <option>--Pilih--</option>
                                  <option value="1">Servis Masuk</option>
                                  <option value="2">Menunggu Sparepart</option>
                                  <option value="3">Sparepart Datang</option>
                                  <option value="4">Proses Servis</option>
                                  <option value="5">Bisa Diambil</option>
                                  <option value="6">Sudah Diambil</option>
                                  <option value="8">Tidak Bisa</option>
                                  <option value="9">Komplain Garansi</option>
                                  <option value="0">Cancel</option>
                              </select>
                          </span>
                      </div>
                  </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-auto">
              <?php if ( $ds_status == 0 || $ds_status == 1 || $ds_status == 5 || $ds_status == 6 || $ds_status == 7 || $ds_status == 8 || $ds_status == 9  ) : ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 6%;">No.</th>
                    <th style="width: 13%;">Nota</th>
                    <th>Customer</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Tanggal Ambil</th>
                    <th style="text-align: center; width: 6%">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

              <?php else : ?>
                <?php  
                  $i = 1;
                  $data = query("SELECT * FROM data_servis WHERE ds_status = $ds_status && ds_cabang = $sessionCabang ORDER BY ds_id DESC ");
                ?>

                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 6%;">No.</th>
                    <th style="width: 13%;">Nota</th>
                    <th>Customer</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Start Servis</th>
                    <th>Lama Servis</th>
                    <th style="text-align: center; width: 6%">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ( $data as $row ) : ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?= $row['ds_nota']; ?></td>
                      <td>
                          <?php  
                            $ds_customer_id = $row['ds_customer_id'];
                            $customer_nama = mysqli_query($conn, "SELECT customer_nama FROM customer WHERE customer_id = $ds_customer_id");
                            $customer_nama = mysqli_fetch_array($customer_nama);
                            $customer_nama = $customer_nama['customer_nama'];
                            echo $customer_nama;
                          ?>
                      </td>
                      <td><?= $row['ds_terima_date_time']; ?></td>
                      <td>
                          <?php  
                            $statusServisHistory = $row['ds_status'];
                            include "_status-servis.php"; 
                            echo $sshView;
                          ?>  
                      </td>
                      <td>
                          <?php  
                            $nota   = $row['ds_nota'];
                            $cabang = $row['ds_cabang'];

                            $historyServis = query("SELECT * FROM history_servis_tekinis WHERE hst_nota = $nota && hst_cabang = $cabang && hst_status = 4 ORDER BY hst_id ASC LIMIT 1")[0];
                            
                            echo $historyServis['hst_date_time'];
                          ?>
                      </td>
                      <td>
                          
                          <?php  
                          // Tanggal Utama
                          $tanggal = new DateTime($historyServis['hst_date']);

                          // Tanggal Hari Ini
                          $today = new DateTime('today');

                          // Tahun
                          $tahun = $today->diff($tanggal)->y;

                          // Bulan
                          $bulan = $today->diff($tanggal)->m;

                          // Hari
                          $hari = $today->diff($tanggal)->d;

                          if ( $tahun < 1 && $bulan > 0 && $hari > 0) {
                            $dateServis = $bulan." bulan, ".$hari." hari ";

                          } elseif ( $tahun < 1 && $bulan < 1 && $hari > 0 ) {
                            $dateServis = $hari." hari ";

                          } elseif ( $tahun < 1 && $bulan > 0 && $hari < 1 ) {
                            $dateServis = $bulan." bulan ";

                          } elseif ( $tahun > 0 && $bulan < 1 && $hari > 0 ) {
                            $dateServis = $tahun." tahun, ".$hari." hari ";

                          } elseif ( $tahun > 0 && $bulan < 1 && $hari < 1 ) {
                            $dateServis = $tahun." tahun ";

                          } elseif ( $tahun < 1 && $bulan < 1 && $hari < 1 ) {
                            $dateServis = "Baru Masuk Hari ini";

                          } else {
                            $dateServis = $tahun." tahun, ".$bulan." bulan, ".$hari." hari ";
                          }
                          echo $dateServis;
                        ?>
                      </td>
                      <td class="text-center">
                        <?php $id = $row["ds_id"]; ?>
                        <a href="servis-data-barang-zoom?id=<?= base64_encode($id); ?>" title="Lihat Data" target="_blank">
                              <button class="btn btn-success">
                                 <i class="fa fa-eye"></i>
                              </button>
                          </a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>

              <?php endif; ?>

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


<script>
    $(document).ready(function(){
        var table = $('#example1').DataTable( { 
             "processing": true,
             "serverSide": true,
             "ajax": "laporan-servis-status-data.php?cabang=<?= $sessionCabang; ?>&status=<?= $ds_status; ?>",
             "columnDefs": 
             [
              {
                "targets": -1,
                  "data": null,
                  "defaultContent": 
                  `<center class="text-center">
                      <button class='btn btn-success tblZoom' title='Lihat Data'>
                          <i class='fa fa-eye'></i>
                      </button>&nbsp;
                  </center>` 
              }
            ]
        });

        table.on('draw.dt', function () {
            var info = table.page.info();
            table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });


        $('#example1 tbody').on( 'click', '.tblZoom', function () {
            var data = table.row( $(this).parents('tr')).data();
            var data0 = data[0];
            var data0 = btoa(data0);
            window.open('servis-data-barang-zoom?id='+ data0, '_blank');
        });
    });
  </script>


<?php include '_footer.php'; ?>


<script>
  $(function () {
    $("#example1").DataTable();
  });

  function myFunction() {
    var x = document.getElementById("mySelect").value;
    if ( x === "0" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(0); ?>";

    } else if ( x === "1" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(1); ?>";

    } else if ( x === "2" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(2); ?>";

    } else if ( x === "3" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(3); ?>";

    } else if ( x === "4" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(4); ?>";

    } else if ( x === "5" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(5); ?>";

    } else if ( x === "6" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(6); ?>";

    } else if ( x === "7" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(7); ?>";

    } else if ( x === "8" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(8); ?>";

    } else if ( x === "9" ) {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(9); ?>";

    } else {
      document.location.href = "laporan-servis-status?status=<?= base64_encode(0); ?>";

    }
  }
</script>
</body>
</html>