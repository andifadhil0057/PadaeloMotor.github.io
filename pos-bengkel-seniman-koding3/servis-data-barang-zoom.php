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
<?php  
// ambil data di URL
$id = abs((int)base64_decode($_GET['id']));


// query data berdasarkan id
$servis = query("SELECT * FROM data_servis WHERE ds_id = $id ")[0];
$nota         = $servis['ds_nota'];
$status       = $servis['ds_status'];
$cabangServis = $servis['ds_cabang'];

  // cek apakah tombol submit sudah ditekan atau belum
  if( isset($_POST["submit"]) ){
    // var_dump($_POST);

    // cek apakah data berhasil di tambahkan atau tidak
    if( editServisTeknisi($_POST) > 0 ) {
      echo "
        <script>
          alert('Data Berhasil Tersimpan !!');
          document.location.href = '';
        </script>
      ";
    } elseif( editServisTeknisi($_POST) == null ) {
      echo "
        <script>
          alert('Anda Belum Melakukan Perubahan Data !!');
          document.location.href = '';
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


  // Update Data Produk SN dan Non SN 
  if ( isset($_POST["updateSn"]) ) {
    if( updateSnServis($_POST) > 0 ) {
      echo "
        <script>
          document.location.href = '';
        </script>
      ";
    } else {
      echo "
        <script>
          alert('Data Gagal edit');
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
            <h1>Data Servis <b>No. Nota <?= $nota; ?></b> - <b style="color: red;">No. Antian <?= $servis['ds_antrian']; ?></b></h1>
            <?php 
              if ( $servis['ds_tipe_servis'] < 1 ) {
                $ds_tipe_servis = "Datang Langsung";
              } else {
                $ds_tipe_servis = "Booking Online";
              }
            ?>
            <small>
              <?= tanggal_indo($servis['ds_terima_date']); ?> - <b>Tipe Servis: <?= $ds_tipe_servis; ?> </b>
            </small>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data Servis</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Data Customer & Kendaraan Servis <b>No. Nota <?= $servis['ds_nota']; ?></b></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                </div>
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
                            <label for="ds_kategori_jenis_barang_servis_id">Kategori Servis / No. Pol / Kendaraan</label>
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
                <div class="text-center cta-detail-mekanik">
                    <a data-toggle="modal" href='#modal-data-servis' class="btn btn-info">Detail Kendaraan Servis <i class="fa fa-cogs"></i></a>
                    
                    <a href="customer-zoom?id=<?= base64_encode($servis['ds_customer_id']); ?>" class="btn btn-success" target="_blank">Identitas Customer &nbsp;<i class="fa fa-user"></i></a>
                   
                    <a href="kendaraan-zoom?id=<?= base64_encode($servis['ds_kendaraan_id']); ?>" class="btn btn-warning" target="_blank">Identitas Kendaraan &nbsp;<i class="fa fa-bookmark"></i></a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content" id="biaya-jasa">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <h3 class="card-title card-title-biaya-jasa-servis">Biaya Jasa Servis <b>No. Nota <?= $nota; ?></b></h3>
                    </div>
                    <div class="col-md-4 col-lg-4">
                      <div class="cari-barang-parent">
                      </div>
                  </div>
                </div>
              </div>

              <?php  
                $biayaServis = query("SELECT * FROM data_servis_teknisi WHERE dst_id_nota = $nota && dst_cabang = $sessionCabang  ORDER BY dst_id ASC ");
              ?>
              <div class="card-body">
                <div class="table-auto">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 6%;">No.</th>
                        <th>Kategori Sevis</th>
                        <th>Nama Servis</th>
                        <th>Mekanik</th>
                        <th>Biaya</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                          $no         = 1;
                          $total      = 0; 
                      ?>
                      <?php 
                          foreach ( $biayaServis as $row ) :
                          $total      += $row['dst_servis_biaya'] 
                      ?>
                      <tr>
                        <td><?= $no; ?></td>
                        <td>
                            <?php  
                                $kategoriId = $row['dst_kategori_servis'];
                                $namaKategori = mysqli_query($conn, "SELECT kategori_servis_nama FROM kategori_servis WHERE kategori_servis_id = $kategoriId");
                                $namaKategori = mysqli_fetch_array($namaKategori);
                                $kategori_servis_nama = $namaKategori['kategori_servis_nama'];
                                echo $kategori_servis_nama;
                            ?>                         
                        </td>
                        <td><?= $row['dst_nama_servis']; ?></td>
                        <td>
                          <?php  
                            $dst_teknisi_id = $row['dst_teknisi_id'];

                            if ( $dst_teknisi_id < 1 ) {
                              echo "-";
                            } else {
                              $namaMekanik = mysqli_query($conn, "SELECT user_nama FROM user WHERE user_id = $dst_teknisi_id ");
                              $namaMekanik = mysqli_fetch_array($namaMekanik);
                              $namaMekanik = $namaMekanik['user_nama'];
                              echo $namaMekanik;
                            }
                          ?>
                        </td>
                        <td>Rp. <?= number_format($row['dst_servis_biaya'], 0, ',', '.'); ?></td>
                        <?php if ( $status != 6 && $status != 7 && $status != 8 && $status != 0  ) { ?>
                        <?php } ?>
                      </tr>
                      <?php $no++; ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="btn-transaksi">
                  <div class="row">
                    <div class="col-md-6 col-lg-7"></div>
                    <div class="col-md-6 col-lg-5">
                        <div class="invoice-table">
                          <table class="table">
                            <tr>
                                <td><b>Total Biaya Jasa</b></td>
                                <td class="table-nominal">
                                   <span>Rp. </span>
                                   <span>
                                      <input type="text" name="total_biaya_servis" id="total_biaya_servis" class="a2"  value="<?php echo number_format($total, 0, ',', '.'); ?>" onkeyup="return isNumberKey(event)" size="10" readonly>
                                   </span>
                                   
                                </td>
                            </tr>
                          </table>
                        </div>
                    </div>
                  </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <br>
    <section class="content" id="biaya-sparepart">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              Menambahkan Produk pada Data Biaya Sparepart Servis maka secara otomatis akan <b>Mengurangi Stok</b> Produk tersebut.
            </div>
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <h3 class="card-title card-title-biaya-jasa-servis">Biaya Sparepart <b>No. Nota <?= $nota; ?></b></h3>
                    </div>
                    <div class="col-md-4 col-lg-4">
                      <div class="cari-barang-parent">
                      </div>
                  </div>
                </div>
              </div>

              <?php  
                $keranjang = query("SELECT * FROM data_servis_sparepart WHERE dss_nota = $nota && dss_cabang = $sessionCabang ORDER BY dss_id ASC");
              ?>
              <div class="card-body">
                <div class="table-auto">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 6%;">No.</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th style="text-align: center;">QTY</th>
                        <th>No. SN</th>
                        <th style="width: 20%;">Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $i                    = 1; 
                        $total_beli           = 0;
                        $total_sparepart      = 0;
                      ?>
                      <?php 
                        foreach($keranjang as $row) : 

                        $bik = $row['barang_id'];
                        $stockParent = mysqli_query( $conn, "select barang_stock from barang where barang_id = '".$bik."'");
                        $brg = mysqli_fetch_array($stockParent); 
                        $tb_brg = $brg['barang_stock'];

                        $sub_total_beli = $row['dss_harga_beli'] * $row['dss_qty'];
                        $sub_total      = $row['dss_harga'] * $row['dss_qty'];
              
                        $total_beli      += $sub_total_beli;
                        $total_sparepart += $sub_total;
                      ?>
                      <tr>
                          <td><?= $i; ?></td>
                          <td><?= $row['dss_nama'] ?></td>
                          <td>Rp. <?= number_format($row['dss_harga'], 0, ',', '.'); ?></td>
                          <td style="text-align: center;"><?= $row['dss_qty']; ?></td>
                          <td>
                            <?php  
                              if ( $row['dss_barang_option_sn'] < 1 ) {
                                $sn = "Non-SN";
                              } else {
                                  $sn = $row['dss_sn'];
                                  if ( $row['dss_sn'] < 1 ) {
                                    echo '
                                      <span class="keranjang-right">
                                        <button class=" btn-success" name="" class="keranjang-pembelian"    id="dss_sn" data-id="'.$row['dss_id'].'">
                                         <i class="fa fa-edit"></i>
                                        </button> 
                                      </span>';
                                  } 
                              }
                              echo $sn;
                            ?>
                          </td>
                          <td>Rp. <?= number_format($sub_total, 0, ',', '.'); ?></td>
                      </tr>
                      <?php $i++; ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="btn-transaksi">
                  <div class="row">
                    <div class="col-md-6 col-lg-7"></div>
                    <div class="col-md-6 col-lg-5">
                        <div class="invoice-table">
                          <table class="table">
                            <tr>
                                <td><b>Total Biaya Sparepart</b></td>
                                <td class="table-nominal">
                                   <span>Rp. </span>
                                   <span>
                                      <input type="text" name="total_biaya_servis" id="total_biaya_servis" class="a2"  value="<?php echo number_format($total_sparepart, 0, ',', '.'); ?>" onkeyup="return isNumberKey(event)" size="10" readonly>
                                   </span>
                                   
                                </td>
                            </tr>
                          </table>
                        </div>
                    </div>
                  </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content" id="history-servis">
      <div class="container-fluid">
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
      <div class="container-fluid">
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
      <div class="container-fluid">
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
                            <?php  
                              $totalKeseluruhan = $total + $total_sparepart;
                            ?>
                            <input type="text" name="ds_total" class="form-control" id="ds_total" value="<?php echo number_format($totalKeseluruhan, 0, ',', '.'); ?>" readonly>
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
                            <?php  
                              $totalServis = $totalKeseluruhan - $servis['ds_dp'];
                            ?>
                            <input type="number" name="ds_dp" class="form-control" id="ds_dp"  value="<?php echo number_format($totalServis, 0, ',', '.'); ?>" readonly>
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
                            <label for="">Servis Berkala</label>
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


                <div class="card-footer text-right">
                  <a href="#!" class="btn btn-success float-right" onclick="self.close()" style="margin-right: 5px;"> Kembali</a>
                </div>
              </form>
          </div>
        </div>
      </div>
    </section>
  </div>

    <div class="modal fade" id="modal-id" data-backdrop="static">
        <div class="modal-dialog modal-lg-pop-up">
          <div class="modal-content">
            <div class="modal-body">
                  <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Jasa Servis Keseluruhan</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-auto">
                    <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
                      <thead>
                      <tr>
                        <th style="width: 4%;">No.</th>
                        <th>Kode Servis</th>
                        <th>Nama Servis</th>
                        <th>Kategori</th>
                        <th>Biaya</th>
                        <th style="text-align: center;">Aksi</th>
                      </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
                </div>
              </div>
                <!-- /.card-body -->
              </div>    
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="modal-id-2" data-backdrop="static">
        <div class="modal-dialog modal-lg-pop-up">
          <div class="modal-content">
            <div class="modal-body">
                  <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Sparepart Servis</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-auto">
                    <table id="example2" class="table table-bordered table-striped" style="width: 100%;">
                      <thead>
                      <tr>
                        <th style="width: 5%;">No.</th>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th style="text-align: center;">Aksi</th>
                      </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
                </div>
              </div>
                <!-- /.card-body -->
              </div>    
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
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
