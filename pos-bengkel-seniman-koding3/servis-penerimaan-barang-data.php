	
	<?php  
		include '_header-artibut.php';
      	$data = query("SELECT * FROM data_servis WHERE ds_status = 1 && ds_cabang = $sessionCabang ORDER BY ds_id ASC");
    ?>
    
<div class="container-fluid">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Servis Masuk</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-auto">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 8%;">No.</th>
                    <th>No. Antrian</th>
                    <th>Customer</th>
                    <th>No. Pol</th>
                    <th>Kendaraan</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th style="text-align: center; width: 14%;">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php $i = 1; ?>
                  <?php foreach ( $data as $row ) : ?>
                  <tr>
                      <td><?= $i; ?></td>
                      <td><?= $row['ds_antrian']; ?></td>
                      <td>
                      	  <?php  
                      	  	$ds_customer_id = $row['ds_customer_id'];

                      	  	$namaCustomer = mysqli_query($conn, "select customer_nama, customer_tlpn, customer_alamat from customer where customer_id = ".$ds_customer_id." ");
                      	  	$nc = mysqli_fetch_array($namaCustomer);
                      	  	$customer_nama   = $nc['customer_nama'];
                      	  	$customer_tlpn   = $nc['customer_tlpn'];
                      	  	$customer_alamat = $nc['customer_alamat'];
                      	  	echo $customer_nama;
                      	  ?>	
                      </td>
                      <td>
                          <?php  
                            $ds_kendaraan_id = $row['ds_kendaraan_id'];
                            $namaKendaraan = mysqli_query($conn, "select kendaraan_nopol, kendaraan_merek, kendaraan_tipe, kendaraan_jenis from kendaraan where kendaraan_id = ".$ds_kendaraan_id." ");
                            $nk = mysqli_fetch_array($namaKendaraan);
                            $kendaraan_nopol    = $nk['kendaraan_nopol'];
                            $kendaraan_merek    = $nk['kendaraan_merek'];
                            $kendaraan_tipe     = $nk['kendaraan_tipe'];
                            $kendaraan_jenis    = $nk['kendaraan_jenis'];
                            echo $kendaraan_nopol;
                          ?>
                      </td>
                      <td>
                          <?= $kendaraan_merek." ".$kendaraan_tipe." ".$kendaraan_jenis; ?>
                      </td>
                      <td>
                        <?php 
                          if ( $row['ds_tipe_servis'] === "1" ) {
                            echo "<b style='color: #007bff;'>Booking Online</b>";
                          } else {
                            echo "Datang Langsung";
                          }
                        ?>    
                      </td>
                      <td>
                        <?php 
                          if ( $row['ds_status'] === "1" ) {
                            echo "<span class='badge badge-secondary'>Antiran Servis Masuk</span>";
                          } else {
                            echo "<b>-</b>";
                          }
                        ?>    
                      </td>
                      <td class="orderan-online-button">
                        <?php $id = $row["ds_id"]; ?>
                        <a href="servis-dikerjakan-detail?id=<?= base64_encode($id) ?>" title="Edit Data" id="edit_servis" data-id="<?= $id; ?>">
                              <button class="btn btn-primary" type="submit">
                                 <i class="fa fa-edit"></i>
                              </button>
                          </a>
                        <a href="nota-servis-antrian?id=<?= base64_encode($id); ?>" title="Print No. Antrian" target="_blank">
                              <button class="btn btn-warning" type="submit">
                                 <i class="fa fa-print"></i>
                              </button>
                        </a>
                        <?php 
                            $noHp  = substr_replace($customer_tlpn,'62',0,1);
                            $namaKonter = $dataTokoLogin['toko_nama']." ".$dataTokoLogin['toko_kota'];
                            $cekServis = $dataTokoLogin['toko_link']."/cek-servis?data=".base64_encode($row['ds_cabang'])."-".base64_encode($row['ds_nota']);
                            $koma  = '%2C'; 
                            $spasi = '%0A';
                            $garis = '------------------------------------------------------';

                            // Mencari Nama Barang
                            $dkjbsi_id = $row['ds_kategori_jenis_barang_servis_id'];
                      	  	$namaKategori = mysqli_query($conn, "select kategori_servis_nama from kategori_servis where kategori_servis_id = ".$dkjbsi_id." ");
                      	  	$nk = mysqli_fetch_array($namaKategori);
                      	  	$kategori_servis_nama   = $nk['kategori_servis_nama'];

                            $kendaraan = $kendaraan_nopol." ".$kendaraan_merek." ".$kendaraan_tipe." ".$kendaraan_jenis;

                            $isiWa = "*TANDA TERIMA SERVIS*".$spasi.$namaKonter.$spasi.$spasi.$garis.$spasi.$spasi."Nota: ".$row['ds_nota'].$spasi."Nama: ".$customer_nama.$spasi."Tgl. Diterima: ".tanggal_indo($row['ds_terima_date']).$spasi."Tlpn: ".$customer_tlpn.$spasi."Alamat: ".$customer_alamat.$spasi.$spasi.$garis.$spasi.$spasi."Kendaraan: ".$kendaraan." ".$spasi.$spasi.$garis.$spasi.$spasi."Cek Servis: ".$cekServis.$spasi.$spasi;
                         ?>
                          <a href="https://api.whatsapp.com/send?phone=<?= $noHp; ?>&text=<?= $isiWa; ?>" target="_blank" title="Nota WhatsApp">
                              <button class="btn btn-success" type="submit">
                                 <i class="fa fa-whatsapp"></i>
                              </button>
                          </a>
                          <a href="servis-penerimaan-barang-delete?id=<?= base64_encode($id); ?>" onclick="return confirm('Yakin dihapus ?')" title="Delete Data">
                              <button class="btn btn-danger" type="submit" name="hapus">
                                  <i class="fa fa-trash-o"></i>
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
    <!-- /.content -->
</div>

  
  


<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>

