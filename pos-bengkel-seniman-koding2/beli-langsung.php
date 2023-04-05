<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>

<?php  
  if ( $levelLogin === "kurir" && $levelLogin === "mekanik") {
    echo "
      <script>
        document.location.href = 'bo';
      </script>
    ";
  }  


if ( $dataTokoLogin['toko_status'] < 1 ) {
  echo "
      <script>
        alert('Status Toko Tidak Aktif Jadi Anda Tidak Bisa melakukan Transaksi !!');
        document.location.href = 'bo';
      </script>
    ";
}



// Insert Ke keranjang Scan Barcode
if( isset($_POST["inputbarcode"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( tambahKeranjangBarcode($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = '';
      </script>
    ";
  }  
}
?>



<?php 
error_reporting(0);
// Insert Ke keranjang
$inv = $_POST["penjualan_invoice2"];
if( isset($_POST["updateStock"]) ){
  // var_dump($_POST);
  $sql = mysqli_query($conn, "SELECT * FROM invoice WHERE penjualan_invoice='$inv' && invoice_cabang = '$sessionCabang' ") or die (mysqli_error($conn));

  $hasilquery = mysqli_num_rows($sql);

  if( $hasilquery == 0){
      // cek apakah data berhasil di tambahkan atau tidak
      if( updateStock($_POST) > 0 ) {
        echo "
          <script>
            document.location.href = 'invoice?no=".$inv."';
          </script>
        ";
      } else {
        echo "
          <script>
            alert('Transaksi Gagal !!');
          </script>
        ";
      }
  }else {
    echo "
        <script>
          document.location.href = 'invoice?no=".$inv."';
        </script>
      ";
  }
}
?>


<?php
  // Update Data Produk SN dan Non SN 
  if ( isset($_POST["updateSn"]) ) {
    if( updateSn($_POST) > 0 ) {
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

  // Update Data Harga Produk di Keranjang
  if ( isset($_POST["updateHarga"]) ) {
    if( updateQTYHarga($_POST) > 0 ) {
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
            <h1>Transaksi Kasir</h1>
            <div class="btn-cash-piutang">
              <?php  
                // Ambil data dari URL Untuk memberikan kondisi transaksi Cash atau Piutang
                if (empty(abs((int)base64_decode($_GET['r'])))) {
                    $r = 0;
                } else {
                    $r = abs((int)base64_decode($_GET['r']));
                }
              ?>

              <?php if ( $r == 1 ) : ?>
              <a href="beli-langsung" class="btn btn-default">Cash</a>
              <a href="beli-langsung?r=MQ==" class="btn btn-primary">Piutang</a>
              <?php else : ?>
              <a href="beli-langsung" class="btn btn-primary">Cash</a>
              <a href="beli-langsung?r=MQ==" class="btn btn-default">Piutang</a>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Barang</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
    <?php  
      $userId = $_SESSION['user_id'];
      $keranjang = query("SELECT * FROM keranjang WHERE keranjang_id_kasir = $userId && keranjang_cabang = $sessionCabang ORDER BY keranjang_id ASC");

      $countInvoice = mysqli_query($conn, "select * from invoice where invoice_cabang = ".$sessionCabang." ");
      $countInvoice = mysqli_num_rows($countInvoice);
      if ( $countInvoice < 1 ) {
        $jmlPenjualan1 = 0;
      } else {
        $penjualan = query("SELECT * FROM invoice WHERE invoice_cabang = $sessionCabang ORDER BY invoice_id DESC lIMIT 1")[0];
        $jmlPenjualan1 = $penjualan['penjualan_invoice_count'];
      }
      $jmlPenjualan1 = $jmlPenjualan1 + 1;
      
      // $penjualan = query("SELECT * FROM invoice WHERE invoice_cabang = $sessionCabang ORDER BY invoice_id DESC lIMIT 1")[0];
      // $jmlPenjualan1 = $penjualan['penjualan_invoice_count'];
      // $jmlPenjualan1 = $jmlPenjualan1 + 1;
    ?>
        <div class="col-lg-12">
        	<div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-8 col-lg-8">
                    <div class="card-invoice">
                      <span>No. Invoice: </span>
                      <?php  
                        $today = date("Ymd");
                        $di = $today.$jmlPenjualan1;
                      ?>
                      <input type="" name="" value="<?= $di; ?>">
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="cari-barang-parent">
                      <div class="row">
                        <div class="col-10">
                            <form action="" method="post">
                                <input type="hidden" name="keranjang_id_kasir" value="<?= $userId; ?>">
                                <input type="hidden" name="keranjang_cabang" value="<?= $sessionCabang; ?>">
                                <input type="text" class="form-control" autofocus="" name="inputbarcode" placeholder="Barcode / Kode Barang" required="">
                            </form>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-primary" title="Cari Produk" data-toggle="modal" id="cari-barang" href='#modal-id'>
                               <i class="fa fa-search"></i>
                            </a>
                        </div>
                      </div>
                    </div>
                </div>
                </div>
              </div>

            <!-- /.card-header -->
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
                  <th style="text-align: center; width: 10%;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $i          = 1; 
                  $total_beli = 0;
                  $total      = 0;
                ?>
                <?php 
                  foreach($keranjang as $row) : 

                  $bik = $row['barang_id'];
                  $stockParent = mysqli_query( $conn, "select barang_stock from barang where barang_id = '".$bik."'");
                  $brg = mysqli_fetch_array($stockParent); 
                  $tb_brg = $brg['barang_stock'];

                  $sub_total_beli = +$row['keranjang_harga_beli'] * $row['keranjang_qty'];
                  $sub_total      = +$row['keranjang_harga'] * $row['keranjang_qty'];
        
                  if ( $row['keranjang_id_kasir'] === $_SESSION['user_id'] ) {
                  $total_beli += $sub_total_beli;
                  $total += $sub_total;
                ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td>
                        <?= $row['keranjang_nama'] ?><br>
                        <small><a href="#!" id="keranjang-rak" data-id="<?= $bik; ?>"><u>Lihat Lokasi Rak</u></a></small>      
                    </td>
                    <td>Rp. <?= number_format($row['keranjang_harga'], 0, ',', '.'); ?></td>
                    <td style="text-align: center;"><?= $row['keranjang_qty']; ?></td>
                    <td>
                      <?php  
                        if ( $row['keranjang_barang_option_sn'] < 1 ) {
                          $sn = "Non-SN";
                        } else {
                            $sn = $row['keranjang_sn'];
                            if ( $row['keranjang_sn'] == null ) {
                              echo '
                                <span class="keranjang-right">
                                  <button class=" btn-success" name="" class="keranjang-pembelian"    id="keranjang_sn" data-id="'.$row['keranjang_id'].'">
                                   <i class="fa fa-edit"></i>
                                  </button> 
                                </span>';
                            } elseif ( $row['keranjang_sn'] === "0" ) {
                              echo '
                                <span class="keranjang-right">
                                  <button class=" btn-success" name="" class="keranjang-pembelian"    id="keranjang_sn" data-id="'.$row['keranjang_id'].'">
                                   <i class="fa fa-edit"></i>
                                  </button> 
                                </span>';
                            } 
                        }
                        echo $sn;
                      ?>
                    </td>
                    <td>Rp. <?= number_format($sub_total, 0, ',', '.'); ?></td>
                    <td class="orderan-online-button">
                        <a href="#!" title="Edit Data">
                          <button class="btn btn-primary" name="" class="keranjang-pembelian" id="keranjang-harga" data-id="<?= $row['keranjang_id']; ?>">
                              <i class="fa fa-pencil"></i>
                          </button> 
                        </a>
                        <a href="beli-langsung-delete?id=<?= $row['keranjang_id']; ?>&r=<?= $r; ?>" title="Delete Data" onclick="return confirm('Yakin dihapus ?')">
                            <button class="btn btn-danger" type="submit" name="hapus">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </a>
                    </td>
                </tr>
                <?php $i++; ?>
                <?php } ?>
                <?php endforeach; ?>
              </table>
              </div>
              
       
              <div class="btn-transaksi">
                <form role="form" action="" method="POST">
                  <div class="row">
                    <div class="col-md-6 col-lg-7">
                        <div class="filter-customer">
                          <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control select2bs4 pilihan-marketplace" required="" name="invoice_customer">
                              <?php if ( $r != 1 ) { ?>
                              <option value="0">Umum</option>
                              <?php } ?>

                              <?php  
                                $customer = query("SELECT * FROM customer WHERE customer_cabang = $sessionCabang && customer_status = '1' ORDER BY customer_id DESC ");
                              ?>
                              <?php foreach ( $customer as $ctr ) : ?>
                                <?php if ( $ctr['customer_id'] > 1 && $ctr['customer_nama'] !== "Customer Umum" ) { ?>
                                <option value="<?= $ctr['customer_id'] ?>"><?= $ctr['customer_nama'] ?></option>
                                <?php } ?>
                              <?php endforeach; ?>
                            </select>
                            <small>
                              <a href="customer-add?kendaraan=<?= base64_encode(0) ?>&penerimaan=<?= base64_encode(0); ?>">Tambah Customer <i class="fa fa-plus"></i></a>
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Tipe Pembayaran</label>
                            <select class="form-control" required="" name="invoice_tipe_transaksi">
                              <option value="0">Cash</option>
                              <option value="1">Transfer</option>
                            </select>
                        </div>

                        <!-- kondisi jika memilih piutang -->
                        <?php if ( $r == 1 ) : ?>
                        <div class="form-group">
                            <label>Jatuh Tempo</label>
                            <input type="date" name="invoice_piutang_jatuh_tempo" class="form-control" raquired>
                        </div>
                       <?php else : ?>
                          <input type="hidden" name="invoice_piutang_jatuh_tempo" value="0">
                       <?php endif; ?>

                      </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                      <div class="invoice-table">
                        <table class="table">
                          <tr>
                              <td><b>Total</b></td>
                              <td class="table-nominal">
                                 <!-- Rp. <?php echo number_format($total, 0, ',', '.'); ?> -->
                                 <span>Rp. </span>
                                 <span>
                                    <input type="text" name="invoice_total" id="angka2" class="c21"  value="<?= $total; ?>" onkeyup="return isNumberKey(event)" size="10" readonly>
                                 </span>
                                 
                              </td>
                          </tr>

                        <!-- Statis untuk Inputan -->
                          <tr class="ongkir-statis">
                              <td>
                                  <b style="color: red;">
                                      <?php  
                                        // kondisi jika memilih piutang
                                        if ( $r == 1 ) {
                                          echo "DP";
                                        } else {
                                          echo "Bayar";
                                        }
                                      ?>      
                                  </b>
                              </td>
                              <td class="table-nominal tn">
                                 <span>Rp.</span> 
                                 <span>
                                   <input type="number" name="angka1" id="angka1" class="d21 ongkir-statis-bayar" autocomplete="off" onkeyup="hitung4();" required onkeyup="return isNumberKey(event)" onkeypress="return hanyaAngka1(event)" size="10">
                                 </span>
                              </td>
                          </tr>
                          <tr class="ongkir-statis">
                              <td>
                                  <?php  
                                    // kondisi jika memilih piutang
                                    if ( $r == 1 ) {
                                        echo "Sisa Piutang";
                                    } else {
                                        echo "Kembali";
                                    }
                                  ?>  
                              </td>
                              <td class="table-nominal">
                                <span>Rp.</span>
                                 <span>
                                  <input type="text" name="hasil" id="hasil" class="e21" readonly size="10" disabled>
                                </span>
                              </td>
                          </tr>
                        <!-- End Statis untuk Inputan -->

                          
                          <tr>
                              <td></td>
                              <td>

                                <?php  foreach ($keranjang as $stk) : ?>
                                <?php if ( $stk['keranjang_id_kasir'] === $userId ) { ?>
                                  <input type="hidden" name="barang_ids[]" value="<?= $stk['barang_id']; ?>">
                                  <input type="hidden" min="1" name="keranjang_qty[]" value="<?= $stk['keranjang_qty']; ?>"> 
                                  <input type="hidden" name="keranjang_harga_beli[]" value="<?= $stk['keranjang_harga_beli']; ?>">
                                  <input type="hidden" name="keranjang_harga[]" value="<?= $stk['keranjang_harga']; ?>">
                                  <input type="hidden" name="keranjang_id_kasir[]" value="<?= $stk['keranjang_id_kasir']; ?>">

                                  <input type="hidden" name="penjualan_invoice[]" value="<?= $di; ?>">
                                  <input type="hidden" name="penjualan_date[]" value="<?= date("Y-m-d") ?>">

                                  <input type="hidden" name="keranjang_barang_option_sn[]" value="<?= $stk['keranjang_barang_option_sn']; ?>">
                                  <input type="hidden" name="keranjang_barang_sn_id[]" value="<?= $stk['keranjang_barang_sn_id']; ?>">
                                  <input type="hidden" name="keranjang_sn[]" value="<?= $stk['keranjang_sn']; ?>">
                                  <input type="hidden" name="penjualan_cabang[]" value="<?= $sessionCabang; ?>">
                                <?php } ?>
                                <?php endforeach; ?>  
                                <input type="hidden" name="penjualan_invoice2" value="<?= $di; ?>">
                                <input type="hidden" name="kik" value="<?= $userId; ?>">
                                <input type="hidden" name="penjualan_invoice_count" value="<?= $jmlPenjualan1; ?>">
                                <input type="hidden" name="invoice_piutang" value="<?= $r; ?>">
                                <input type="hidden" name="invoice_piutang_lunas" value="0">
                                <input type="hidden" name="invoice_cabang" value="<?= $sessionCabang; ?>">
                                <input type="hidden" name="invoice_total_beli" value="<?= $total_beli; ?>">

                                <div class="payment">
                                  <?php  
                                    $idKasirKeranjang = $_SESSION['user_id'];
                                    $dataSn = mysqli_query($conn,"select * from keranjang where keranjang_barang_option_sn > 0 && keranjang_sn != null && keranjang_cabang = $sessionCabang && keranjang_id_kasir = $idKasirKeranjang");
                                    $jmlDataSn = mysqli_num_rows($dataSn);
                                  ?>
                                  <?php if ( $jmlDataSn < 1 ) { ?>
                                    <button class="btn btn-primary" type="submit" name="updateStock">Simpan Payment <i class="fa fa-shopping-cart"></i></button>
                                  <?php } ?>

                                  <?php if ( $jmlDataSn > 0 ) { ?>
                                    <a href="#!" class="btn btn-default jmlDataSn" type="" name="">Simpan Payment <i class="fa fa-shopping-cart"></i></a>
                                  <?php } ?>
                                </div>
                              </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
               </form>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>


    <div class="modal fade" id="modal-id" data-backdrop="static">
        <div class="modal-dialog modal-lg-pop-up">
          <div class="modal-content">
            <div class="modal-body">
                  <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Barang Keseluruhan</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-auto">
                    <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
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
  <div class="modal fade" id="modal-id-1">
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

  <!-- Modal Update Harga Keranjang -->
  <div class="modal fade" id="modal-id-2">
    <div class="modal-dialog">
      <div class="modal-content">

        <form role="form" id="form-edit-harga" method="POST" action="">
          <div class="modal-header">
            <h4 class="modal-title">Edit Produk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" id="data-keranjang-harga">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" name="updateHarga" >Edit Data</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Modal Lihat Lokasi Rak -->
  <div class="modal fade" id="modal-id-3">
    <div class="modal-dialog">
      <div class="modal-content">

        <form role="form" id="form-lihat-rak" method="POST" action="">
          <div class="modal-header">
            <h4 class="modal-title">Lokasi Rak Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" id="data-lihat-rak">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
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
             "ajax": "beli-langsung-search-data.php?cabang=<?= $sessionCabang; ?>",
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
            var data0 = data[0];
            var data0 = btoa(data0);
            window.location.href = "beli-langsung-add?id="+ data0 + "&r=<?= $r; ?>";
        });

    });
  </script>

<?php include '_footer.php'; ?>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>
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
 <script>
      // function hitung2() {
      // var a = $(".a2").val();
      // var b = $(".b2").val();
      // c = a - b;
      // $(".c2").val(c);
      // }

      function hitung2() {
          var txtFirstNumberValue = document.querySelector('.a2').value;
          var txtSecondNumberValue = document.querySelector('.b2').value;
          var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
          if (!isNaN(result)) {
             document.querySelector('.c2').value = result;
          }
      }
      function hitung3() {
        var a = $(".d2").val();
        var b = $(".c2").val();
        c = a - b;
        $(".e2").val(c);
      }
      function hitung4() {
        var a = $(".d21").val();
        var b = $(".c21").val();
        c = a - b;
        $(".e21").val(c);
      }
      function isNumberKey(evt){
       var charCode = (evt.which) ? evt.which : event.keyCode;
       if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
       return false;
       return true;
      }
</script>
<script>
  $(function () {

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
</script>

<script>
  $(document).ready(function(){
      $(".pilihan-marketplace").change(function(){
          $(this).find("option:selected").each(function(){
              var optionValue = $(this).attr("value");
              if(optionValue){
                  $(".box1").not("." + optionValue).hide();
                  $("." + optionValue).show();
              } else{
                  $(".box1").hide();
              }
          });
      }).change();

      // Memanggil Pop Up Data Produk SN dan Non SN
      $(document).on('click','#keranjang_sn',function(e){
          e.preventDefault();
          $("#modal-id-1").modal('show');
          $.post('beli-langsung-sn.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-keranjang-no-sn").html(html);
            }   
          );
        });


      // Memanggil Pop Up Data Edit Harga
      $(document).on('click','#keranjang-harga',function(e){
          e.preventDefault();
          $("#modal-id-2").modal('show');
          $.post('beli-langsung-edit-harga.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-keranjang-harga").html(html);
            }   
          );
        });

      // Memanggil Pop Up Lihat Rak
      $(document).on('click','#keranjang-rak',function(e){
          e.preventDefault();
          $("#modal-id-3").modal('show');
          $.post('beli-langsung-lihat-rak.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-lihat-rak").html(html);
            }   
          );
        });

      $(".jmlDataSn").click(function(){
        alert("Anda Tidak Bisa Melanjutkan Transaksi Karena data No. SN Masih Ada yang Kosong !!");
      });

      // View Hidden Ongkir
      $(".fa-ongkir-statis").click(function(){
          $(".ongkir-statis").addClass("none");
          $(".ongkir-statis-input").attr("name", "");
          $(".ongkir-dinamis-input").attr("name", "invoice_ongkir");

          $(".ongkir-statis-bayar").attr("name", "");
          $(".ongkir-dinamis-bayar").attr("name", "angka1");

          $(".ongkir-statis-bayar").removeAttr("required");
          $(".ongkir-dinamis-bayar").attr("required", true);
          $(".ongkir-dinamis").removeClass("none");
      });

      $(".fa-ongkir-dinamis").click(function(){
          $(".ongkir-dinamis").addClass("none");
          $(".ongkir-dinamis-input").attr("name", "");
          $(".ongkir-statis-input").attr("name", "invoice_ongkir");

          $(".ongkir-dinamis-bayar").attr("name", "");
          $(".ongkir-statis-bayar").attr("name", "angka1");

          $(".ongkir-dinamis-bayar").removeAttr("required");
          $(".ongkir-statis-bayar").attr("required", true);
          $(".ongkir-statis").removeClass("none");
      });
  });

  // load halaman di pilihan select jenis usaha
  $('#beli-langsung-marketplace').load('beli-langsung-marketplace.php');

</script>

</body>
</html>