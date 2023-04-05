<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>
<?php  
  if ( $levelLogin === "kurir") {
    echo "
      <script>
        document.location.href = 'kurir-data';
      </script>
    ";
  }  
?>
  <?php  
    $penjualan = query("SELECT * FROM barang WHERE barang_status != 2 && barang_status != 0 && barang_cabang = $sessionCabang ");
  ?>

  <?php $jmlPenjualan = 0; ?>
  <?php foreach ( $penjualan as $row ) : ?>
    <?php $jmlPenjualan += $row['barang_terjual']; ?>
  <?php endforeach; ?>


  <!-- Total penjualan Nominal hari ini -->
  <?php  
    $totalPenjualanHariIni = 0;
    $tanggalHariIni = date("Y-m-d");
      $queryInvoice = $conn->query("SELECT invoice.invoice_id, invoice.invoice_date, invoice.invoice_cabang, invoice.invoice_sub_total, invoice.penjualan_invoice
        FROM invoice 
        WHERE invoice_cabang = '".$sessionCabang."' && invoice_date = '".$tanggalHariIni."' ORDER BY invoice_id DESC
      ");
    while ($rowProduct = mysqli_fetch_array($queryInvoice)) {
    $totalPenjualanHariIni += $rowProduct['invoice_sub_total'];
  ?>
  <?php } ?>
  <!-- End Total penjualan Nominal hari ini -->

  <?php  

    // Barang
    $barang = mysqli_query($conn,"select * from barang where barang_cabang = ".$sessionCabang."");
    $jmlBarang = mysqli_num_rows($barang);

    // Invoice
    $invoice = mysqli_query($conn,"select * from invoice where invoice_cabang = '".$sessionCabang."' && invoice_piutang < 1 ");
    $jmlInvoice = mysqli_num_rows($invoice);
  ?>


  <!-- Total Invoice hari ini -->
  <?php  
    $invoiceHariIni = mysqli_query($conn,"select * from invoice where invoice_cabang = '".$sessionCabang."' && invoice_date = '".$tanggalHariIni."' && invoice_piutang = 0 && invoice_piutang_lunas = 0 ");
    $jmlInvoiceHariIni = mysqli_num_rows($invoiceHariIni);
  ?>
  <!-- End Total Invoice hari ini -->


  <!-- Servis Masuk Hari Ini -->
  <?php  
    $servisMasuk = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_terima_date = '".$tanggalHariIni."' && ds_cabang = $sessionCabang && ds_status = 1 ");
    $servisMasuk = mysqli_num_rows($servisMasuk);
  ?>
  <!-- End Servis Masuk Hari Ini -->

  <!-- Servis Pengerjaan Hari Ini -->
  <?php  
    $servisPengerjaan = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 4 ");
    $servisPengerjaan = mysqli_num_rows($servisPengerjaan);
  ?>
  <!-- End Servis Pengerjaan Hari Ini -->

  <!-- Servis Bisa Diambil -->
  <?php  
    $servisBisaDiambil = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 5 ");
    $servisBisaDiambil = mysqli_num_rows($servisBisaDiambil);
  ?>
  <!-- End Servis Bisa Diambil -->

  <!-- Servis Diambil Hari Ini -->
  <?php  
    $servisDiambilHariIni = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_ambil_date = '".$tanggalHariIni."' && ds_cabang = $sessionCabang && ds_status = 6 ");
    $servisDiambilHariIni = mysqli_num_rows($servisDiambilHariIni);
  ?>
  <!-- End Servis Diambil Hari Ini -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard <b><?= $tipeToko; ?> <?= $dataTokoLogin['toko_kota']; ?></b></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Rp <?= number_format($totalPenjualanHariIni, 0, ',', '.'); ?></h3>

                <p>Penjualan <b>Hari ini</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-money"></i>
              </div>
              
            </div>
          </div>

          <div class="col-lg-6 col-md-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= singkat_angka($jmlInvoiceHariIni); ?></h3>
                <p>Invoice Penjualan Cash <b>Hari ini</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <!-- small box -->
            <div class="small-box" style="background: #fff;">
              <div class="inner">
                <h3><?= $jmlPenjualan; ?></h3>

                <p><b>Total</b> Barang Terjual</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart" style="color: #17a2b8;"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <!-- small box -->
            <div class="small-box" style="background: #fff;">
              <div class="inner">
                <h3><?= $jmlBarang; ?></h3>

                <p>Jumlah Barang</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-bag" style="color: #28a745;"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <!-- small box -->
            <div class="small-box" style="background: #fff;">
              <div class="inner">
                <h3><?= $jmlInvoice; ?></h3>

                <p><b>Total</b> Invoice Penjualan</p>
              </div>
              <div class="icon">
                <i class="fa fa-table" style="color: #dc3545;"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Servis Masuk <small><b>Hari ini</b></small></span>
                <span class="info-box-number">
                  <?= $servisMasuk; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Proses Pengerjaan</span>
                <span class="info-box-number"><?= $servisPengerjaan; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-bookmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Servis Bisa Diambil</span>
                <span class="info-box-number"><?= $servisBisaDiambil; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-external-link"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Servis Selesai <small><b>Hari ini</b></small></span>
                <span class="info-box-number"><?= $servisDiambilHariIni; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
        </div>
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <section class="table-informasi">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
             <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><b>Data Barang</b> Terlaris</h3>
                </div>
              <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-auto">
                    <table id="" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th>Terjual</th>
                      </tr>
                      </thead>
                      <tbody>

                      <?php 
                        $i = 1; 
                        $queryProduct = $conn->query("SELECT barang.barang_id, barang.barang_kode, barang.barang_nama, barang.barang_harga, barang.barang_terjual, barang.barang_cabang
                                   FROM barang 
                                   WHERE barang_cabang = '".$sessionCabang."' && barang_terjual > 0  ORDER BY barang_terjual DESC LIMIT 5
                                   ");
                        while ($rowProduct = mysqli_fetch_array($queryProduct)) {
                      ?>
                      <tr>
                          <td><?= $i; ?></td>
                          <td><?= $rowProduct['barang_kode']; ?></td>
                          <td><?= $rowProduct['barang_nama']; ?></td>
                          <td>
                            <b><?= $rowProduct['barang_terjual']; ?></b>
                          </td>
                      </tr>
                      <?php $i++; ?>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              <!-- /.card-body -->
              </div>
          </div>

          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Data Stok</b> Terkecil</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-auto">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Kode Barang</th>
                      <th>Nama</th>
                      <th>Stock</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php 
                      $i = 1; 
                      $queryProduct = $conn->query("SELECT barang.barang_id, barang.barang_kode, barang.barang_nama, barang.barang_harga, barang.barang_stock, barang.barang_cabang
                                 FROM barang 
                                 WHERE barang_cabang = '".$sessionCabang."' && barang_stock < 10 ORDER BY barang_stock ASC LIMIT 5
                                 ");
                      while ($rowProduct = mysqli_fetch_array($queryProduct)) {
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $rowProduct['barang_kode']; ?></td>
                        <td><?= $rowProduct['barang_nama']; ?></td>
                        <td>
                          <b><?= $rowProduct['barang_stock']; ?></b>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              <!-- /.card-body -->
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Data Piutang Penjualan</b> Jatuh Tempo Kurang dari 30 Hari</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-auto">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Invoice</th>
                      <th>Transaksi</th>
                      <th>Customer</th>
                      <th>Jatuh Tempo</th>
                      <th>Sub Total</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php 
                      $i = 1; 
                      $date_max  = date('Y-m-d', strtotime('30 days'));
                      $queryProduct = $conn->query("SELECT invoice.invoice_id, invoice.penjualan_invoice, invoice.invoice_date, invoice.invoice_sub_total, invoice.invoice_cabang, invoice.invoice_customer, invoice.invoice_piutang_jatuh_tempo, invoice.invoice_piutang_dp, invoice.invoice_bayar, invoice.invoice_kembali, customer.customer_id, customer.customer_nama, customer.customer_tlpn
                                 FROM invoice 
                                 JOIN customer ON invoice.invoice_customer = customer.customer_id
                                 WHERE invoice_cabang = '".$sessionCabang."' && invoice_piutang > 0 && invoice_piutang_jatuh_tempo <= '".$date_max."' ORDER BY invoice_id DESC
                                 ");
                      while ($rowProduct = mysqli_fetch_array($queryProduct)) {
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $rowProduct['penjualan_invoice']; ?></td>
                        <td><?= tanggal_indo($rowProduct['invoice_date']); ?></td>
                        <td><?= $rowProduct['customer_nama']; ?></td>
                        <td>
                            <?php
                                // Jatuh Tempo
                                $piutangJatuhTempo = tanggal_indo($rowProduct['invoice_piutang_jatuh_tempo']);

                                // Durasi Hari
                                $tgl1 = new DateTime($tanggalHariIni);
                                $tgl2 = new DateTime($rowProduct['invoice_piutang_jatuh_tempo']);
                                $d = $tgl2->diff($tgl1)->days;

                                if ( $tanggalHariIni > $rowProduct['invoice_piutang_jatuh_tempo']) {
                                  $nh = "<span class='badge badge-danger'>Lewat ".$d." Hari</span>";
                                  $dWA = "Lewat ".$d." Hari";
                                  echo "<s>".$piutangJatuhTempo."<s> ".$nh;

                                } else {
                                  if ( $d > 20 ) {
                                     $nh = "<span class='badge badge-warning'>".$d." Hari Lagi</span>";
                                  } elseif ( $d <= 20 ) {
                                      $nh = "<span class='badge badge-danger'>".$d." Hari Lagi</span>";
                                  } else {
                                      $nh = "<span class='badge badge-danger'>".$d." Hari Lagi</span>";
                                  }
                                  $dWA = $d." Hari Lagi";
                                  echo $piutangJatuhTempo." ".$nh;  
                                }
                            ?>
                        </td>
                        <td>
                          Rp. <?= number_format($rowProduct['invoice_sub_total'], 0, ',', '.'); ?>
                        </td>
                        <td class="orderan-online-button">
                            <a href="penjualan-zoom?no=<?= base64_encode($rowProduct['invoice_id']); ?>" target="_blank">
                              <button class='btn btn-info' title='Lihat Data'>
                                <i class='fa fa-eye'></i>
                              </button>
                            </a>

                            <a href="piutang-cicilan?no=<?= base64_encode($rowProduct['invoice_id']); ?>">
                              <button class='btn btn-primary' title='Cicilan'>
                                <i class='fa fa-money'></i>
                              </button>
                            </a>

                            <?php  
                              $no_wa = substr_replace($rowProduct['customer_tlpn'],'62',0,1)
                            ?>
                            <a href="https://api.whatsapp.com/send?phone=<?= $no_wa; ?>&text=Halo <?= $rowProduct['customer_nama'];?>, Kami dari *<?= $dataTokoLogin['toko_nama']; ?> <?= $dataTokoLogin['toko_kota']; ?>* memberikan informasi bahwa transaksi *No Invoice <?= $rowProduct['penjualan_invoice'];?> dengan jumlah transaksi Rp <?= number_format($rowProduct['invoice_sub_total'], 0, ',', '.'); ?>* sudah mendekati jatuh tempo pada <?= $piutangJatuhTempo; ?> (<?= $dWA; ?> dimulai dari tanggal sekarang).%0A%0ASub Total: Rp <?= number_format($rowProduct['invoice_sub_total'], 0, ',', '.'); ?>%2C%0ADP: Rp <?= number_format($rowProduct['invoice_piutang_dp'], 0, ',', '.'); ?>%2C%0ADP ditambah Total Cicilan: Rp <?= number_format($rowProduct['invoice_bayar'], 0, ',', '.'); ?> %2C%0A*Sisa Piutang: Rp <?= number_format($rowProduct['invoice_kembali'], 0, ',', '.'); ?>*%2C%0A%0A%0AMohon Segera Dilunasi" target="_blank">
                              <button class='btn btn-success' title='Cicilan'>
                                <i class='fa fa-whatsapp'></i>
                              </button>
                            </a>

                            <a href="nota-cetak?no=<?= $rowProduct['invoice_id']; ?>" target="_blank">
                              <button class='btn btn-warning' title="Cetak Nota">
                                <i class='fa fa-print'></i>
                              </button>
                            </a>
                        </td>
                    </tr>
                    <?php $i++; ?>

                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              <!-- /.card-body -->
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Data Hutang Pembelian</b> Jatuh Tempo Kurang dari 30 Hari</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-auto">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Invoice</th>
                      <th>Transaksi</th>
                      <th>Supplier</th>
                      <th>Jatuh Tempo</th>
                      <th>Sub Total</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php 
                      $i = 1; 
                      $date_max  = date('Y-m-d', strtotime('30 days'));
                      $queryProduct = $conn->query("SELECT invoice_pembelian.invoice_pembelian_id, 
                        invoice_pembelian.pembelian_invoice, 
                        invoice_pembelian.invoice_date, 
                        invoice_pembelian.invoice_total, 
                        invoice_pembelian.invoice_pembelian_cabang, 
                        invoice_pembelian.invoice_supplier, 
                        invoice_pembelian.invoice_hutang_jatuh_tempo, 
                        invoice_pembelian.invoice_hutang_dp, 
                        invoice_pembelian.invoice_bayar, 
                        invoice_pembelian.invoice_kembali, 
                        supplier.supplier_id, 
                        supplier.supplier_nama, 
                        supplier.supplier_company
                                 FROM invoice_pembelian 
                                 JOIN supplier ON invoice_pembelian.invoice_supplier = supplier.supplier_id
                                 WHERE invoice_pembelian_cabang = '".$sessionCabang."' && invoice_hutang > 0 && invoice_hutang_jatuh_tempo <= '".$date_max."' ORDER BY invoice_pembelian_id DESC
                                 ");
                      while ($rowProduct = mysqli_fetch_array($queryProduct)) {
                    ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $rowProduct['pembelian_invoice']; ?></td>
                        <td><?= tanggal_indo($rowProduct['invoice_date']); ?></td>
                        <td><?= $rowProduct['supplier_company']; ?> - <?= $rowProduct['supplier_nama']; ?></td>
                        <td>
                            <?php
                                // Jatuh Tempo
                                $hutangJatuhTempo = tanggal_indo($rowProduct['invoice_hutang_jatuh_tempo']);

                                // Durasi Hari
                                $tgl1a = new DateTime($tanggalHariIni);
                                $tgl2a = new DateTime($rowProduct['invoice_hutang_jatuh_tempo']);
                                $da = $tgl2a->diff($tgl1a)->days;

                                if ( $tanggalHariIni > $rowProduct['invoice_hutang_jatuh_tempo']) {
                                  $nha = "<span class='badge badge-danger'>Lewat ".$da." Hari</span>";
                                  echo "<s>".$hutangJatuhTempo."<s> ".$nha;

                                } else {
                                  if ( $da > 20 ) {
                                     $nha = "<span class='badge badge-warning'>".$da." Hari Lagi</span>";
                                  } elseif ( $da <= 20 ) {
                                      $nha = "<span class='badge badge-danger'>".$da." Hari Lagi</span>";
                                  } else {
                                      $nha = "<span class='badge badge-danger'>".$da." Hari Lagi</span>";
                                  }
                                  echo $hutangJatuhTempo." ".$nha;
                                } 
                            ?>
                        </td>
                        <td>
                          Rp. <?= number_format($rowProduct['invoice_total'], 0, ',', '.'); ?>
                        </td>
                        <td class="orderan-online-button">
                            <a href="pembelian-zoom?no=<?= base64_encode($rowProduct['invoice_pembelian_id']); ?>" target="_blank">
                              <button class='btn btn-info' title='Lihat Data'>
                                <i class='fa fa-eye'></i>
                              </button>
                            </a>

                            <a href="hutang-cicilan?no=<?= base64_encode($rowProduct['invoice_pembelian_id']); ?>">
                              <button class='btn btn-primary' title='Cicilan'>
                                <i class='fa fa-money'></i>
                              </button>
                            </a>

                            <a href="nota-cetak-pembelian?no=<?= $rowProduct['invoice_pembelian_id']; ?>" target="_blank">
                              <button class='btn btn-warning' title="Cetak Nota">
                                <i class='fa fa-print'></i>
                              </button>
                            </a>
                        </td>
                    </tr>
                    <?php $i++; ?>

                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              <!-- /.card-body -->
              </div>
            </div>
          </div>


          <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><b>Status Servis</b> Keseluruhan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-auto">
                <table id="data-laporan-status-berdasarkan-periode" class="table table-bordered table-striped">
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
                      <td><b>Antrian Servis Masuk</b> </td>
                      <td style="text-align: center;">
                        <?php  
                          $servisMasuk = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 1 ");
                          $servisMasuk = mysqli_num_rows($servisMasuk);
                          echo singkat_angka($servisMasuk)." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>2</td>
                      <td><b>Menunggu Sparepart</b> </td>
                      <td style="text-align: center;">
                        <?php  
                          $menungguSparepart = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 2 ");
                          $menungguSparepart = mysqli_num_rows($menungguSparepart);
                          echo singkat_angka($menungguSparepart)." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>3</td>
                      <td><b>Sparepart Datang</b> </td>
                      <td style="text-align: center;">
                        <?php  
                          $sparepartDatang = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 3 ");
                          $sparepartDatang = mysqli_num_rows($sparepartDatang);
                          echo singkat_angka($sparepartDatang)." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>4</td>
                      <td><b>Proses Servis</b> </td>
                      <td style="text-align: center;">
                        <?php  
                          $prosesServis = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 4 ");
                          $prosesServis = mysqli_num_rows($prosesServis);
                          echo singkat_angka($prosesServis)." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>5</td>
                      <td><b>Bisa Diambil</b> </td>
                      <td style="text-align: center;">
                        <?php  
                          $bisaDiambil = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 5 ");
                          $bisaDiambil = mysqli_num_rows($bisaDiambil);
                          echo singkat_angka($bisaDiambil)." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>6</td>
                      <td><b>Sudah Diambil</b></td>
                      <td style="text-align: center;">
                        <?php  
                          $sudahDiambil = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 6 ");
                          $sudahDiambil = mysqli_num_rows($sudahDiambil);
                          echo singkat_angka($sudahDiambil)." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>7</td>
                      <td><b>Tidak Bisa</b> </td>
                      <td style="text-align: center;">
                        <?php  
                          $tidakBisa = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 8 ");
                          $tidakBisa = mysqli_num_rows($tidakBisa);
                          echo singkat_angka($tidakBisa)." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>8</td>
                      <td><b>Komplain Garansi</b></td>
                      <td style="text-align: center;">
                        <?php  
                          $komplainGaransi = mysqli_query($conn, "SELECT * FROM data_servis WHERE  ds_cabang = $sessionCabang && ds_status = 9 ");
                          $komplainGaransi = mysqli_num_rows($komplainGaransi);
                          echo singkat_angka($komplainGaransi)." x";
                        ?>
                      </td>
                  </tr>
                  <tr>
                      <td>9</td>
                      <td><b>Cancel</b> </td>
                      <td style="text-align: center;">
                        <?php  
                          $cancel = mysqli_query($conn, "SELECT * FROM data_servis WHERE ds_cabang = $sessionCabang && ds_status = 0 ");
                          $cancel = mysqli_num_rows($cancel);
                          echo singkat_angka($cancel)." x";
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
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <?php  if ( $levelLogin !== "mekanik") { ?>
  <section class="kasir-bo">
    <a href="beli-langsung">
      <img src="dist/img/kasir.png" alt="POS Seniman Koding" class="img-fluid"> 
    </a>   
  </section>
  <?php } ?>

<?php include '_footer.php'; ?>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $("#example2").DataTable();
  });
</script>