<?php  
	include '_header-artibut.php';
	$id = $_GET['id'];

	// query data berdasarkan id
	$servis       = query("SELECT * FROM data_servis WHERE ds_id = $id ")[0];
	$nota         = $servis['ds_nota'];
	$status       = $servis['ds_status'];
	$cabangServis = $servis['ds_cabang'];
?>


			<div class="cetak-nota-servis-wa text-center">
                <a href="nota-servis?id=<?= base64_encode($servis['ds_id']); ?>" class="btn btn-warning" target="_blank">Print Nota <i class="fa fa-print"></i></a>

                <?php 
                    // Mencari No. Tlpn Customer
                	$customer_id = $servis['ds_customer_id'];
                    $ds_kendaraan_id       = $servis['ds_kendaraan_id'];
                    $customer_nama = mysqli_query($conn, "select customer_nama, customer_tlpn, customer_alamat from customer where customer_id = ".$customer_id." ");
                    $c_n = mysqli_fetch_array($customer_nama);
                    $customer_nama    = $c_n['customer_nama'];
                    $customer_tlpn    = $c_n['customer_tlpn'];
                    $customer_alamat  = $c_n['customer_alamat'];

                    $namaKendaraan = mysqli_query($conn, "select kendaraan_nopol, kendaraan_merek, kendaraan_tipe, kendaraan_jenis from kendaraan where kendaraan_id = ".$ds_kendaraan_id." ");
                    $nk = mysqli_fetch_array($namaKendaraan);
                    $kendaraan_nopol    = $nk['kendaraan_nopol'];
                    $kendaraan_merek    = $nk['kendaraan_merek'];
                    $kendaraan_tipe     = $nk['kendaraan_tipe'];
                    $kendaraan_jenis    = $nk['kendaraan_jenis'];

                    $kendaraan = $kendaraan_nopol." ".$kendaraan_merek." ".$kendaraan_tipe." ".$kendaraan_jenis;

                    $noHp  = substr_replace($customer_tlpn,'62',0,1);
                    $namaKonter = $dataTokoLogin['toko_nama']." ".$dataTokoLogin['toko_kota'];
                    $cekServis  = $dataTokoLogin['toko_link']."/cek-servis?data=".base64_encode($servis['ds_cabang'])."-".base64_encode($servis['ds_nota']);
                    $koma  = '%2C'; 
                    $spasi = '%0A';
                    $garis = '------------------------------------------------------';

                    // Mencari Nama Barang
                    $dkjbsi_id = $servis['ds_kategori_jenis_barang_servis_id'];
                    $namaKategori = mysqli_query($conn, "select kategori_servis_nama from kategori_servis where kategori_servis_id = ".$dkjbsi_id." ");
                    $nk = mysqli_fetch_array($namaKategori);
                    $kategori_servis_nama   = $nk['kategori_servis_nama'];

                    $isiWa = "*TANDA KOMPLAIN SERVIS*".$spasi.$namaKonter.$spasi.$spasi.$garis.$spasi.$spasi."Nota: ".$servis['ds_nota'].$spasi."Nama: ".$customer_nama.$spasi."Tgl. Diterima: ".tanggal_indo($servis['ds_terima_date']).$spasi."Tlpn: ".$customer_tlpn.$spasi."Alamat: ".$customer_alamat.$spasi.$spasi.$garis.$spasi.$spasi."kendaraan: ".$kendaraan." ".$spasi."Kerusakan: ".$servis['ds_kerusakan'].$spasi.$spasi.$garis.$spasi.$spasi."Total Biaya Servis: ".number_format($servis['ds_total'], 0, ',', '.').$spasi."DP (Bayar Diawal): ".number_format($servis['ds_dp'], 0, ',', '.').$spasi."*Total Sisa Bayar: ".number_format($servis['ds_total_sisa_bayar'], 0, ',', '.')."*".$spasi.$spasi.$garis.$spasi.$spasi."Garansi Servis: ".tanggal_indo($servis['ds_garansi']).$spasi.$spasi.$garis.$spasi.$spasi."Tgl Komplain: ".tanggal_indo($servis['ds_garansi_komplain_date']).$spasi."Keluhan Komplain: ".$servis['ds_garansi_komplain_note'].$spasi."Cek Status Barang Servis bisa dengan klik link berikut: ".$cekServis.$spasi.$spasi;
                ?>
                <a href="https://api.whatsapp.com/send?phone=<?= $noHp; ?>&text=<?= $isiWa; ?>" class="btn btn-success" target="_blank">Nota WA <i class="fa fa-whatsapp"></i></a>

                <?php 
                    // Mencari No. Tlpn Customer
                    $user_id = $servis['ds_teknisi'];
                    $teknisi_data = mysqli_query($conn, "select user_nama, user_no_hp from user where user_id = ".$user_id." ");
                    $t_d = mysqli_fetch_array($teknisi_data);
                    $user_nama    = $t_d['user_nama'];
                    $user_tlpn    = $t_d['user_no_hp'];

                    $noHpTeknisi  = substr_replace($user_tlpn,'62',0,1);


                    $isiWaTeknisi = "*TANDA KOMPLAIN SERVIS*".$spasi.$namaKonter.$spasi.$spasi.$garis.$spasi.$spasi."Halo ".$user_nama.$spasi."Nota: ".$servis['ds_nota']." Telah melakukan komplain garansi pada tanggal ".$servis['ds_garansi_komplain_date_time']." dengan keluhan ".$servis['ds_garansi_komplain_note'].$spasi." Mohon Segera di eksekusi agar cepat beres dan bisa diambil customer".$spasi."Cek Status Barang Servis bisa dengan klik link berikut: ".$cekServis.$spasi.$spasi;
                ?>
            </div>