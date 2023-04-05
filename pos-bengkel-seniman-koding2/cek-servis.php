<?php  
  include 'aksi/functions.php';

  $dataUrl       = $_GET['data'];
  $pecah_data    = explode("-",$dataUrl);
  $cabang        = $pecah_data[0];
  $nota          = $pecah_data[1];


  $sessionCabang = abs((int)base64_decode($cabang));
  $dataTokoLogin = query("SELECT * FROM toko WHERE toko_cabang = $sessionCabang")[0];
  if ( $sessionCabang < 1 ) {
      $tipeToko = "Pusat";
  } else {
      $tipeToko = "Cabang ".$sessionCabang;
  }


  $id = abs((int)base64_decode($nota));
  // query data berdasarkan id
  $servis = query("SELECT * FROM data_servis WHERE ds_nota = $id && ds_cabang = $sessionCabang ")[0];
  $nota         = $servis['ds_nota'];
  $status       = $servis['ds_status'];
  $cabangServis = $servis['ds_cabang'];
?> 

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS SERVIS - Seniman Koding</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <!-- Favicon -->
  <link rel="icon" type="img/png" sizes="32x32" href="http://senimankoding.com/assets/img/favicon.png">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="dist/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Sweetalert -->
  <link rel="stylesheet" type="text/css" href="dist/node_modules/sweetalert2/dist/sweetalert2.css">

  <link rel="stylesheet" type="text/css" href="dist/css/style.css">

  <!-- Export Excel -->
  <link rel="stylesheet" type="text/css" href="dist/css/tableexport.min.css">
  <style>
    caption.tableexport-caption {
      caption-side: top !important;
    }
    .button-default.txt {
      display: none !important;
    }
  </style>


  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Sweetalert -->
  <script src="dist/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>
<style>
  body:not(.sidebar-mini-md) .content-wrapper, body:not(.sidebar-mini-md) .main-footer, body:not(.sidebar-mini-md) .main-header {
    transition: margin-left .3s ease-in-out;
    margin-left: 0px;
  }
</style>
<body class="">
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
  <div class="">
    <br>
    <div class="llb-header">
        <div class="llb-header-parent">
            <?= $dataTokoLogin['toko_nama']; ?>
        </div>
        <div class="llb-header-address">
            <?= $dataTokoLogin['toko_kota']; ?>
        </div>
        <div class="llb-header-contact">
            <ul>
                <li><b>No.tlpn:</b> <?= $dataTokoLogin['toko_tlpn']; ?></li>&nbsp;&nbsp;
                <li><b>Wa:</b> <?= $dataTokoLogin['toko_wa']; ?></li>
            </ul>
        </div>
    </div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-12">
            <h3>Data Servis <b>No. Nota <?= $nota; ?></b> - <b style="color: red;">No. Antian <?= $servis['ds_antrian']; ?></b></h3>
            <small>
              <?= tanggal_indo($servis['ds_terima_date']); ?> 
            </small>
          </div>
        </div>
      </div><!-- /.container -->
    </section>

    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Data Customer & Barang Servis <b>No. Nota <?= $servis['ds_nota']; ?></b></h3>
              </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="ds_customer_id">Nama Customer</label>
                          <?php  
                                $customer_id = $servis['ds_customer_id'];
                                $customer_nama = mysqli_query($conn, "select customer_nama, customer_tlpn from customer where customer_id = ".$customer_id." ");
                                $c_n = mysqli_fetch_array($customer_nama);
                                $customer_nama = $c_n['customer_nama'];
                                $customer_tlpn = $c_n['customer_tlpn'];
                          ?>
                          <input type="text" name="ds_customer_id" class="form-control" id="ds_customer_id" value="<?= $customer_nama; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                            <?php  
                                $penerimaId = $servis['ds_penerima_id'];
                                $penerima = mysqli_query($conn, "select user_nama from user where user_id = ".$penerimaId." ");
                                $penerima = mysqli_fetch_array($penerima);
                                $penerima = $penerima['user_nama'];
                            ?>
                            <label for="ds_terima_date_time">Penerima / Tanggal Terima</label>
                            <input type="text" name="ds_terima_date_time" class="form-control" id="ds_terima_date_time" value="<?= $penerima; ?> / <?= $servis['ds_terima_date_time']; ?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                            <label for="ds_kategori_jenis_barang_servis_id">Kategori Servis / Merek / Seri</label>
                            <?php  
                                $dkjbsi_id = $servis['ds_kategori_jenis_barang_servis_id'];
                                $dkjbsi = mysqli_query($conn, "select kategori_servis_nama from kategori_servis where kategori_servis_id = ".$dkjbsi_id." ");
                                $dkjbsi = mysqli_fetch_array($dkjbsi);
                                $dkjbsi = $dkjbsi['kategori_servis_nama'];
                            ?>
                            <?php  
                              $ds_kendaraan_id = $servis['ds_kendaraan_id'];
                              $namaKendaraan = mysqli_query($conn, "select kendaraan_nopol, kendaraan_merek, kendaraan_tipe, kendaraan_jenis from kendaraan where kendaraan_id = ".$ds_kendaraan_id." ");
                              $nk = mysqli_fetch_array($namaKendaraan);
                              $kendaraan_nopol    = $nk['kendaraan_nopol'];
                              $kendaraan_merek    = $nk['kendaraan_merek'];
                              $kendaraan_tipe     = $nk['kendaraan_tipe'];
                              $kendaraan_jenis    = $nk['kendaraan_jenis'];
                            ?>
                            <input type="text" name="ds_kategori_jenis_barang_servis_id" class="form-control" id="ds_kategori_jenis_barang_servis_id" value="<?= $dkjbsi; ?> / <?= $kendaraan_nopol; ?> / <?= $kendaraan_merek.' '.$kendaraan_tipe.' '.$kendaraan_jenis; ?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                      <div class="form-group">
                          <label for="ds_kerusakan">Kerusakan</label>
                          <input type="text" name="ds_kerusakan" class="form-control" id="ds_kerusakan" value="<?= $servis['ds_kerusakan']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <a data-toggle="modal" href='#modal-data-servis' class="btn btn-info">Detail Kendaraan Servis <i class="fa fa-cogs"></i></a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <section class="content" id="history-servis">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <h3 class="card-title card-title-biaya-jasa-servis">History Servis <b>No. Nota <?= $nota; ?></b></h3>
                    </div>
                    <div class="col-md-4 col-lg-4"></div>
                </div>
              </div>

              <div class="card-body">
                  <div class="row">
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="ds_terima_date_time">Tanggal Masuk</label>
                            <input type="text" name="ds_terima_date_time" class="form-control" id="ds_terima_date_time" placeholder="Contoh: Kondisi Oke" value="<?= $servis['ds_terima_date_time']; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="ds_customer_id">Penerima / Pembuat Nota Penerimaan Servis</label>
                            <input type="text" name="ds_customer_id" class="form-control" id="ds_customer_id" value="<?= $penerima; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="ds_status">Status Servis Saat Ini Tanggal <?= tanggal_indo(date("Y-m-d")); ?></label>
                            <?php  
                                  $statusServisSaatIni = $servis['ds_status'];
                                  if ( $statusServisSaatIni == 1 ) {
                                    $sssi = "Servis Masuk";

                                  } elseif ( $statusServisSaatIni == 2 ) {
                                    $sssi = "Menunggu Sparepart";

                                  } elseif ( $statusServisSaatIni == 3 ) {
                                    $sssi = "Sparepart Datang";
                                    
                                  } elseif ( $statusServisSaatIni == 4 ) {
                                    $sssi = "Proses Servis";
                                    
                                  } elseif ( $statusServisSaatIni == 5 ) {
                                    $sssi = "Bisa Diambil";
                                    
                                  } elseif ( $statusServisSaatIni == 6 ) {
                                    $sssi = "Sudah Diambil";
                                    
                                  }elseif ( $statusServisSaatIni == 7 ) {
                                    $sssi = "Oper Teknisi Lain";
                                    
                                  } elseif ( $statusServisSaatIni == 8 ) {
                                    $sssi = "Tidak Bisa";
                                    
                                  } else {
                                    $sssi = "Cancel";
                                  }
                                ?>  
                            <input type="text" name="ds_status" class="form-control" id="ds_status" value="<?= $sssi; ?>" readonly>
                          </div>
                      </div>
                  </div>  
              </div>

              <div class="card-body-table">
                  <?php  
                    $data = query("SELECT * FROM history_servis_tekinis WHERE hst_nota = $nota && hst_cabang = $cabangServis ORDER BY hst_id ASC");
                  ?>

                  <div class="card-header">
                    <h3 class="card-title">Detail History Servis</h3>
                  </div>
                  <div class="card-body">
                    <div class="table-auto">
                      <table id="" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th style="width: 7%;">No.</th>
                          <th>Waktu Eksekusi</th>
                          <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ( $data as $row ) : ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['hst_date_time']; ?></td>
                            <td>
                                <?php  
                                  $statusServisHistory = $row['hst_status'];
                                  include "_status-servis.php"; 
                                  echo $sshView;
                                ?>  
                            </td>
                        </tr>
                        <?php $i++; ?>
                      <?php endforeach; ?>
                      </tbody>
                      </table>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content" id="komplain-garansi">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <h3 class="card-title card-title-biaya-jasa-servis">Komplain Garansi Servis <b>No. Nota <?= $nota; ?></b></h3>
                    </div>
                    <div class="col-md-4 col-lg-4"></div>
                </div>
              </div>

              <div class="card-body">
                  <div class="row">
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                              <label for="ds_garansi_komplain_note">Keluhan Komplain Garansi Servis</label>
                              <textarea name="ds_garansi_komplain_note" id="ds_garansi_komplain_note" class="form-control"  rows="4" readonly=""><?= $servis['ds_garansi_komplain_note']; ?></textarea>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                            <?php  
                                $penerimaKomplainId = $servis['ds_garansi_komplain_penerima_id'];
                                $penerimaKomplain = mysqli_query($conn, "select user_nama from user where user_id = ".$penerimaKomplainId." ");
                                $penerimaKomplain = mysqli_fetch_array($penerimaKomplain);
                                $penerimaKomplain = $penerimaKomplain['user_nama'];
                            ?>
                            <label for="ds_kerusakan">Penerima Komplain Garansi</label>
                            <input type="text" name="ds_kerusakan" class="form-control" id="ds_kerusakan" value="<?= $penerimaKomplain; ?>" readonly>
                      </div>
                  </div>  
              </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content" id="informasi-servis">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <h3 class="card-title card-title-biaya-jasa-servis">Informasi Servis <b>No. Nota <?= $nota; ?></b></h3>
                    </div>
                    <div class="col-md-4 col-lg-4"></div>
                </div>
              </div>

              <form role="form" action="" method="post">
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="ds_total">Sub Total Biaya Servis</label>

                            <input type="text" name="ds_total" class="form-control" id="ds_total" value="<?php echo number_format($servis['ds_total'], 0, ',', '.'); ?>" readonly>
                            <small>
                              <b class="red">
                                Total Biaya Servis Merupakan Penjumlahan Dari Total Biaya Jasa + Total Harga Sparepart
                              </b>
                            </small>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="ds_dp">DP (Bayar Diawal)</label>
                            <input type="number" name="ds_dp" class="form-control" id="ds_dp"  value="<?php echo number_format($servis['ds_dp'], 0, ',', '.'); ?>" readonly>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="ds_dp">Total Sisa Bayar</label>

                            <input type="number" name="ds_dp" class="form-control" id="ds_dp"  value="<?php echo number_format($servis['ds_total_sisa_bayar'], 0, ',', '.'); ?>" readonly>
                          </div>
                      </div>

                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                            <label for="ds_kondisi_barang">Kondisi Barang Servis</label>
                            <input type="text" name="ds_kondisi_barang" class="form-control" id="ds_kondisi_barang" placeholder="Contoh: Kondisi Oke" value="<?= $servis['ds_kondisi_barang']; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                          <div class="form-group">
                              <label for="ds_note">Catatan Teknisi (optional)</label>
                              <textarea name="ds_note" id="ds_note" class="form-control" readonly rows="4"><?= $servis['ds_note']; ?></textarea>
                          </div>
                      </div>

                      <div class="col-md-6 col-lg-6">    
                          <div class="form-group ">
                              <label for="ds_status">Status Servis</label>
                              <div class="">
                                <?php  
                                  if ( $status == 1 ) {
                                    $teksStatus = "Antrian Servis Masuk";

                                  } elseif ( $status == 2 ) {
                                    $teksStatus = "Menunggu Sparepart";

                                  } elseif ( $status == 3 ) {
                                    $teksStatus = "Sparepart Datang";

                                  } elseif ( $status == 4 ) {
                                    $teksStatus = "Proses Servis";

                                  } elseif ( $status == 5 ) {
                                    $teksStatus = "Bisa Diambil";

                                  } elseif ( $status == 6 ) {
                                    $teksStatus = "Sudah Diambil";

                                  } elseif ( $status == 7 ) {
                                    $teksStatus = "Oper Teknisi Lain";
                                    
                                  } elseif ( $status == 8 ) {
                                    $teksStatus = "Tidak Bisa";
                                    
                                  } elseif ( $status == 9 ) {
                                    $teksStatus = "Komplain Garansi";
                                    
                                  } else {
                                    $teksStatus = "Cancel";
                                  }
                                ?>
                                <input type="text" name="ds_kondisi_barang" class="form-control" id="ds_kondisi_barang" value="<?= $teksStatus; ?>" readonly>
                              </div>
                          </div>
                      </div>

                      <?php if ( $servis['ds_servis_berkala'] > 0 ) { ?>
                      <div class="col-md-6 col-lg-6">   
                          <div class="form-group">
                            <label for="">Servis Berkala (Datang Kembali)</label>
                            <?php  
                                $ds_servis_berkala_waktu_teks = $servis['ds_servis_berkala_waktu_teks'];
                                if ( $ds_servis_berkala_waktu_teks === "days" ) {
                                  $dgwt = "Hari";
                                } elseif ( $ds_servis_berkala_waktu_teks === "month" ) {
                                  $dgwt = "Bulan";
                                } elseif ( $ds_servis_berkala_waktu_teks === "year" ) {
                                  $dgwt = "Tahun";
                                }
                              ?>
                            <input type="text" name="" class="form-control" value="<?= $servis['ds_servis_berkala_waktu_angka']; ?> <?= $dgwt; ?> (<?= $servis['ds_servis_berkala_date_time']; ?>)" readonly>
                          </div>
                      </div>
                      <?php } ?>

                      <?php if ( $servis['ds_garansi'] > 0 ) { ?>
                      <div class="col-md-6 col-lg-6">   
                          <div class="form-group">
                            <label for="">Servis Garansi</label>
                            <?php  
                                $ds_garansi_waktu_teks = $servis['ds_garansi_waktu_teks'];
                                if ( $ds_garansi_waktu_teks === "days" ) {
                                  $dgwt2 = "Hari";
                                } elseif ( $ds_garansi_waktu_teks === "month" ) {
                                  $dgwt2 = "Bulan";
                                } elseif ( $ds_garansi_waktu_teks === "year" ) {
                                  $dgwt2 = "Tahun";
                                }
                              ?>
                            <input type="text" name="" class="form-control" value="<?= $servis['ds_garansi_waktu_angka']; ?> <?= $dgwt2; ?> (<?= $servis['ds_garansi_date_time']; ?>)" readonly>
                          </div>
                      </div>
                      <?php } ?>
                  </div>  
                </div>

              </form>
          </div>
        </div>
      </div>
    </section>
  </div>


    <!-- Modal Update SN -->
    <div class="modal fade" id="modal-id-1" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">

          <form role="form" id="form-edit-no-sn" method="POST" action="">
            <div class="modal-header">
              <h4 class="modal-title">No. SN Produk</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="data-keranjang-no-sn">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="updateSn" >Edit Data</button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <div class="modal fade modal-input-servis" id="modal-data-servis" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="" id="form-input-servis" method="post" >
            <div class="modal-header">
              <h4 class="modal-title">Data Servis No. Nota <?= $nota; ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="data-input-servis">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                            <label for="ds_kategori_jenis_barang_servis_id">Kategori Barang</label>
                            <?php  
                                $dkjbsi_id = $servis['ds_kategori_jenis_barang_servis_id'];
                                $dkjbsi = mysqli_query($conn, "select kategori_servis_nama from kategori_servis where kategori_servis_id = ".$dkjbsi_id." ");
                                $dkjbsi = mysqli_fetch_array($dkjbsi);
                                $dkjbsi = $dkjbsi['kategori_servis_nama'];
                            ?>
                            <input type="text" name="ds_kategori_jenis_barang_servis_id" class="form-control" id="ds_kategori_jenis_barang_servis_id" value="<?= $dkjbsi; ?>" readonly >
                        </div>
                      </div>
   
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="ds_kerusakan">Kerusakan</label>
                          <input type="text" name="ds_kerusakan" class="form-control" id="ds_kerusakan" value="<?= $servis['ds_kerusakan']; ?>" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_keterangan">Keterangan/Keluhan</label>
                            <textarea name="ds_keterangan" id="ds_keterangan" class="form-control"  rows="4" readonly><?= $servis['ds_keterangan']; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_kondisi_unit_masuk">Kondisi Kendaraan Masuk </label>
                            <input type="text" name="ds_kondisi_unit_masuk" class="form-control" id="ds_kondisi_unit_masuk" value="<?= $servis['ds_kondisi_unit_masuk']; ?>" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ds_kendaraan_km">KM Sekarang </label>
                            <input type="number" name="ds_kendaraan_km" class="form-control" id="ds_kendaraan_km" value="<?= $servis['ds_kendaraan_km']; ?>" placeholder="Input KM Kendaraan" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="ds_dp">DP</label>
                          <input type="text" name="ds_dp" class="form-control" id="ds_dp" value="<?= $servis['ds_dp']; ?>" readonly>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <script>
    $(document).ready(function(){
        var table = $('#example1').DataTable( { 
             "processing": true,
             "serverSide": true,
             "ajax": "servis-dikerjakan-detail-jasa-servis.php?cabang=<?= $sessionCabang; ?>",
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
                  `<center>

                      <button class='btn btn-primary tblInsert' title="Tambah Keranjang">
                         <i class="fa fa-shopping-cart"></i> Pilih
                      </button>

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

        $('#example1 tbody').on( 'click', '.tblInsert', function () {
            var data = table.row( $(this).parents('tr')).data();
            var data0 = btoa(data[0]);
            window.location.href = "servis-dikerjakan-detail-add-jasa?id="+ data0 + "&nota=<?= $nota; ?>" + "&link=<?= $_GET['id']; ?>";
        });

    });
  </script>

  <script>
    $(document).ready(function(){
        var table = $('#example2').DataTable( { 
             "processing": true,
             "serverSide": true,
             "ajax": "servis-dikerjakan-detail-barang-servis-data.php?cabang=<?= $sessionCabang; ?>",
             "columnDefs": 
             [
              {
                "targets": 3,
                  "render": $.fn.dataTable.render.number( '.', '', '', 'Rp. ' )
                 
              },
              {
                "targets": -1,
                  "data": null,
                  "defaultContent": 
                  `<center>

                      <button class='btn btn-primary tblInsertSparepart' title="Tambah Keranjang">
                         <i class="fa fa-shopping-cart"></i> Pilih
                      </button>

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

        $('#example2 tbody').on( 'click', '.tblInsertSparepart', function () {
            var data = table.row( $(this).parents('tr')).data();
            var data0 = data[0];
            var data0 = btoa(data0);
            window.location.href = "servis-dikerjakan-detail-add-sparepart?id="+ data0 + "&nota=<?= $nota; ?>" + "&link=<?= $_GET['id']; ?>";
        });

    });
  </script>

  <script>
    $(document).ready(function(){
      // Memanggil Pop Up Data Produk SN dan Non SN
      $(document).on('click','#dss_sn',function(e){
          e.preventDefault();
          $("#modal-id-1").modal('show');
          $.post('servis-dikerjakan-detail-sn.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-keranjang-no-sn").html(html);
            }   
          );
        });

      $(".jmlDataSn").click(function(){
        alert("Anda Tidak Bisa Melanjutkan Transaksi Karena data No. SN Masih Ada yang Kosong di tabel sparepart !!");
      });
    });
  </script>
<?php include '_footer.php'; ?>