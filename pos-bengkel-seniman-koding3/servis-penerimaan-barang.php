<?php 
  include '_header.php';
  include '_nav.php';
  include '_sidebar.php'; 
?>

<?php  
  

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
  // var_dump($_POST);

  // cek apakah data berhasil di tambahkan atau tidak
  if( tambahKategoriServis($_POST) > 0 ) {
    echo "
      <script>
        document.location.href = 'servis-penerimaan-barang';
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
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Penerimaan Servis</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="bo">Home</a></li>
              <li class="breadcrumb-item active">Data Penerimaan Servis</li>
            </ol>
          </div>
          <div class="tambah-data">
            <a href='#' class="btn btn-primary" id="btn-input-servis">Tambah Data</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <span id="servis-penerimaan-barang-data"></span>

  </div>



    <div class="modal fade modal-input-servis" id="modal-id" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="servis-penerimaan-barang-input.php" id="form-input-servis" method="post" >
            <div class="modal-header">
              <h4 class="modal-title">Data Servis Masuk</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="data-input-servis">
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="servisPenerimaanBarang">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <div class="modal fade modal-input-servis" id="modal-id-cetak" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Print Nota & WhatsApp</h4>
              <button type="button" class="close closeModal" >&times;</button>
            </div>
            <div class="modal-body" id="data-cetak-servis">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default closeModal" id="closeModal">Close</button>
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade modal-input-servis" id="modal-id-input" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Tipe Customer</h4>
              <button type="button" class="close closeModal" >&times;</button>
            </div>
            <div class="modal-body" id="data-cetak-servis">
                <div class="cetak-nota-servis-wa text-center">
                    <a href="customer-add?kendaraan=<?= base64_encode(1); ?>&penerimaan=<?= base64_encode(1); ?>" class="btn btn-success">Customer Baru</a>

                    <a href="kendaraan-add?penerimaan=<?= base64_encode(1); ?>&customer=<?= base64_encode(0); ?>" class="btn btn-info">Customer Terdaftar</a>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default closeModal" id="closeModal">Close</button>
            </div>
        </div>
      </div>
    </div>
    

<?php include '_footer.php'; ?>

<?php  
  $kendaraan = base64_decode($_GET['kendaraan']);
  // Kondisi pop up tampil otomatis jika setelah input data kendaraan
?>
<?php if ( $kendaraan > 0 ) { ?>
<script>
    $(window).on('load', function() {
      $('#modal-id').modal('show');
      $.post('servis-penerimaan-barang-modal.php?kendaraan=<?= $kendaraan; ?>',
        function(html){
          $("#data-input-servis").html(html);
        }   
      );
    });
</script>
<?php } ?>

<script>

  $(document).ready(function(){
    // Memanggil data servis
    $('#servis-penerimaan-barang-data').load('servis-penerimaan-barang-data.php');

    // Memanggil modal input
    $(document).on('click','#btn-input-servis',function(e){
      e.preventDefault();
      $("#modal-id").modal('show');
      $.post('servis-penerimaan-barang-modal.php?kendaraan=<?= $kendaraan; ?>',
        function(html){
          $("#data-input-servis").html(html);
        }   
      );
    });

    // input servis
    $('#form-input-servis').submit(function(e){
      e.preventDefault();

      var dataFormUser = $('#form-input-servis').serialize();
      $.ajax({
        url: "servis-penerimaan-barang-input.php",
        type: "post",
        data: dataFormUser,
        success: function(result) {
          var hasil = JSON.parse(result);
          if (hasil.hasil !== "sukses") {
            Swal.fire(
              'Gagal',
              'Gagal Tersimpan !! CEK KONEKSI INTERNET Anda',
              'error'
            );
            document.location.href="";
          } else {
            $('#modal-id').modal('hide');
            $(".form-control").val('');
            $('#data-input-servis').remove('servis-penerimaan-barang-modal.php');
            $('#servis-penerimaan-barang-data').load('servis-penerimaan-barang-data.php');
            Swal.fire(
              'Sukses !!',
              'Data Berhasil Tersimpan',
              'success'
            );
            $("#modal-id-cetak").modal('show');
            $('#data-cetak-servis').load('servis-penerimaan-barang-data-cetak-servis.php');
          }
        }
      });
    });

    $(document).ready(function(){
      $(".closeModal").click(function(){
          document.location.href="servis-penerimaan-barang?kendaraan=<?= base64_encode(0); ?>";
      });
    });



  });
</script>