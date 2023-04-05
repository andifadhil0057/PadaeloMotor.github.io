<?php  
	include '_header-artibut.php';
?>


			<?php  
                $infoCetakServis = query("SELECT * FROM data_servis WHERE ds_penerima_id = $userIdLogin && ds_cabang = $sessionCabang ORDER BY ds_id DESC LIMIT 1 ")[0];
            ?>
                <div class="cetak-nota-servis-wa text-center">
                  <a href="nota-servis-antrian?id=<?= base64_encode($infoCetakServis['ds_id']); ?>" class="btn btn-warning" target="_blank">Print No. Antrian <i class="fa fa-print"></i></a>

                <?php 
                    // Mencari No. Tlpn Customer
                    $ds_customer_id = $infoCetakServis['ds_customer_id'];
                    $ds_kendaraan_id = $infoCetakServis['ds_kendaraan_id'];

                    $namaCustomer = mysqli_query($conn, "select customer_nama, customer_tlpn, customer_alamat from customer where customer_id = ".$ds_customer_id." ");
                    $nc = mysqli_fetch_array($namaCustomer);
                    $customer_nama   = $nc['customer_nama'];
                    $customer_tlpn   = $nc['customer_tlpn'];
                    $customer_alamat = $nc['customer_alamat'];

                    $namaKendaraan = mysqli_query($conn, "select kendaraan_nopol, kendaraan_merek, kendaraan_tipe, kendaraan_jenis from kendaraan where kendaraan_id = ".$ds_kendaraan_id." ");
                    $nk = mysqli_fetch_array($namaKendaraan);
                    $kendaraan_nopol    = $nk['kendaraan_nopol'];
                    $kendaraan_merek    = $nk['kendaraan_merek'];
                    $kendaraan_tipe     = $nk['kendaraan_tipe'];
                    $kendaraan_jenis    = $nk['kendaraan_jenis'];

                    $kendaraan = $kendaraan_nopol." ".$kendaraan_merek." ".$kendaraan_tipe." ".$kendaraan_jenis;

                    $noHp  = substr_replace($customer_tlpn,'62',0,1);
                    $namaKonter = $dataTokoLogin['toko_nama']." ".$dataTokoLogin['toko_kota'];
                    $cekServis = $dataTokoLogin['toko_link']."/cek-servis?data=".base64_encode($infoCetakServis['ds_cabang'])."-".base64_encode($infoCetakServis['ds_nota']);
                    $koma  = '%2C'; 
                    $spasi = '%0A';
                    $garis = '------------------------------------------------------';

                    // Mencari Nama Barang
                    $dkjbsi_id = $infoCetakServis['ds_kategori_jenis_barang_servis_id'];
                    $namaKategori = mysqli_query($conn, "select kategori_servis_nama from kategori_servis where kategori_servis_id = ".$dkjbsi_id." ");
                    $nk = mysqli_fetch_array($namaKategori);
                    $kategori_servis_nama   = $nk['kategori_servis_nama'];

                    $isiWa = "*TANDA TERIMA SERVIS*".$spasi.$namaKonter.$spasi.$spasi.$garis.$spasi.$spasi."No. Antrian Servis: ".$infoCetakServis['ds_antrian'].$spasi."Nama: ".$customer_nama.$spasi."Tgl. Diterima: ".tanggal_indo($infoCetakServis['ds_terima_date']).$spasi."Tlpn: ".$customer_tlpn.$spasi."Alamat: ".$customer_alamat.$spasi.$spasi.$garis.$spasi.$spasi."Kendaraan: ".$kendaraan." ".$spasi.$spasi.$garis.$spasi.$spasi."Cek Servis: ".$cekServis.$spasi.$spasi;
                ?>
                <a href="https://api.whatsapp.com/send?phone=<?= $noHp; ?>&text=<?= $isiWa; ?>" class="btn btn-success" target="_blank">No. Antrian WA <i class="fa fa-whatsapp"></i></a>

                </div>