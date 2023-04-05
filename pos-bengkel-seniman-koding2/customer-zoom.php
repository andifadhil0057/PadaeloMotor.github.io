<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>

<?php  
// ambil data di URL
$id = abs((int)base64_decode($_GET['id']));


// query data mahasiswa berdasarkan id
$customer = query("SELECT * FROM customer WHERE customer_id = $id ")[0];

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( editCustomer($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'customer';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('Data GAGAL Ditambahkan');
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
            <h1>Edit Data Customer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data Customer</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Data Customer</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 col-lg-6">
                      <input type="hidden" name="customer_id" value="<?= $customer['customer_id']; ?>">
                        <div class="form-group">
                          <label for="customer_nama">Nama Lengkap</label>
                          <input type="text" name="customer_nama" class="form-control" id="customer_nama" value="<?= $customer['customer_nama']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="customer_tlpn">No. Hp</label>
                            <input type="text" name="customer_tlpn" class="form-control" id="customer_tlpn" value="<?= $customer['customer_tlpn']; ?>" readonly>
                        </div>
                         <div class="form-group">
                          <label for="customer_email">Email</label>
                          <input type="email" name="customer_email" class="form-control" id="customer_email" value="<?= $customer['customer_email']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="customer_alamat">Alamat</label>
                            <textarea name="customer_alamat" id="customer_alamat" class="form-control" readonly style="height:123px;"><?= $customer['customer_alamat']; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="customer_count_invoice">Pembelian</label>
                          <input type="text" name="customer_count_invoice" class="form-control" id="customer_count_invoice" value="<?= $customer['customer_count_invoice']; ?> x" readonly>
                        </div>
                         <div class="form-group">
                          <label for="customer_count_servis">Servis</label>
                          <input type="text" name="customer_count_servis" class="form-control" id="customer_count_servis" value="<?= $customer['customer_count_servis']; ?> x" readonly>
                        </div>
                        <div class="form-group ">
                          <label for="customer_status">Status</label>
                                <?php  
                                  if ( $customer['customer_status'] === "1" ) {
                                    $status = "Active";
                                  } else {
                                    $status = "Not Active";
                                  }
                                ?>
                                <input type="text" name="customer_status" class="form-control" id="customer_status" value="<?= $status; ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="customer_create">Waktu Create</label>
                          <input type="text" name="customer_create" class="form-control" id="customer_create" value="<?= $customer['customer_create']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-12">
          <?php
            $kendaraan_pemilik = $customer['customer_id'];  
            $kendaraan = query("SELECT * FROM kendaraan WHERE kendaraan_pemilik = $kendaraan_pemilik && kendaraan_cabang = $sessionCabang ");
          ?>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Kendaraan Customer <?= $customer['customer_nama']; ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-auto">
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 6%;">No.</th>
                  <th>No. Pol</th>
                  <th>Merek</th>
                  <th>Tipe</th>
                  <th>Jenis</th>
                  <th style="text-align: center; width: 6%;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ( $kendaraan as $row ) : ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td><?= $row['kendaraan_nopol']; ?></td>
                    <td><?= $row['kendaraan_merek']; ?></td>
                    <td><?= $row['kendaraan_tipe']; ?></td>
                    <td><?= $row['kendaraan_jenis']; ?></td>
                    <td style="text-align: center;">
                        <a href="kendaraan-zoom?id=<?= base64_encode($row['kendaraan_id']); ?>" title="Lihat Data" target="_blank">
                            <button class="btn btn-success" type="submit">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a>
                    </td>
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

    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">History Pembelian Customer <?= $customer['customer_nama']; ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-auto">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 6%;">No.</th>
                  <th>Invoice</th>
                  <th>Tanggal Transaksi</th>
                  <th>Kasir</th>
                  <th>Sub Total</th>
                  <th style="text-align: center; width: 6%;">Aksi</th>
                </tr>
                </thead>
                <tbody>

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

    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data History Servis Customer <?= $customer['customer_nama']; ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-auto">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 6%;">No.</th>
                    <th style="width: 13%;">Nota</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Tanggal Ambil</th>
                    <th style="text-align: center; width: 6%">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer text-right">
                <a href="#!" class="btn btn-success float-right" onclick="self.close()" style="margin-right: 5px;"> Kembali</a>
            </div>  
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>



  <script>
    $(document).ready(function(){
        var table = $('#example1').DataTable( { 
             "processing": true,
             "serverSide": true,
             "ajax": "customer-penjualan-data.php?cabang=<?= $sessionCabang; ?>&id=<?= $id; ?>",
             "columnDefs": 
             [
              {
                "targets": 4,
                  "render": $.fn.dataTable.render.number( '.', '', '', 'Rp. ' )
                 
              },
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
            window.open('penjualan-zoom?no='+ data0, '_blank');
        });

    });
  </script>

  <script>
    $(document).ready(function(){
        var table = $('#example2').DataTable( { 
             "processing": true,
             "serverSide": true,
             "ajax": "customer-servis-data.php?cabang=<?= $sessionCabang; ?>&id=<?= $id; ?>",
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

        $('#example2 tbody').on( 'click', '.tblZoom', function () {
            var data = table.row( $(this).parents('tr')).data();
            var data0 = data[0];
            var data0 = btoa(data0);
            window.open('servis-data-barang-zoom?id='+ data0, '_blank');
        });

    });
  </script>
<?php include '_footer.php'; ?>