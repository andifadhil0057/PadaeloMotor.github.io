<?php 
include 'aksi/koneksi.php';
$cabang = $_GET['cabang'];

// Data Bulan
    $januari    = 31;
    $februari   = 28;
    $maret      = 31;
    $april      = 30;
    $mei        = 31;
    $juni       = 30;
    $juli       = 31;
    $agustus    = 31;
    $september  = 30;
    $oktober    = 31;
    $november   = 30;
    $desember   = 31;

$tanggalSekarang = date("Y-m-d");
$pecah_data                     = explode("-",$tanggalSekarang);
$ds_garansi_date_time_thn       = $pecah_data[0];
$ds_garansi_date_time_bln       = $pecah_data[1];

if ( $ds_garansi_date_time_bln === "01" ) {
  $dayPeriode = $januari;

} elseif ( $ds_garansi_date_time_bln === "02" ) {
  $dayPeriode = $februari;

} elseif ( $ds_garansi_date_time_bln === "03" ) {
  $dayPeriode = $maret;

} elseif ( $ds_garansi_date_time_bln === "04" ) {
  $dayPeriode = $april;

} elseif ( $ds_garansi_date_time_bln === "05" ) {
  $dayPeriode = $mei;

} elseif ( $ds_garansi_date_time_bln === "06" ) {
  $dayPeriode = $juni;

} elseif ( $ds_garansi_date_time_bln === "07" ) {
  $dayPeriode = $juli;

} elseif ( $ds_garansi_date_time_bln === "08" ) {
  $dayPeriode = $agustus;

} elseif ( $ds_garansi_date_time_bln === "09" ) {
  $dayPeriode = $september;

} elseif ( $ds_garansi_date_time_bln === "10" ) {
  $dayPeriode = $oktober;

} elseif ( $ds_garansi_date_time_bln === "11" ) {
  $dayPeriode = $november;

} elseif ( $ds_garansi_date_time_bln === "12" ) {
  $dayPeriode = $desember;

}

$tanggal_awal  = $ds_garansi_date_time_thn."-".$ds_garansi_date_time_bln."-01";
$tanggal_akhir = $ds_garansi_date_time_thn."-".$ds_garansi_date_time_bln."-".$dayPeriode;

// Database connection info 
$dbDetails = array( 
    'host' => $servername, 
    'user' => $username, 
    'pass' => $password, 
    'db'   => $db
); 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
      a.ds_id, 
      a.ds_nota,
      a.ds_customer_id,
      a.ds_terima_date_time, 
      a.ds_status, 
      a.ds_ambil_date_time,
      a.ds_teknisi,
      a.ds_servis_berkala,
      a.ds_servis_berkala_date_time,
      a.ds_servis_berkala_status,
      a.ds_cabang,
      b.customer_id,
      b.customer_nama
    FROM data_servis a
    LEFT JOIN customer b ON a.ds_customer_id = b.customer_id
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'ds_id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'ds_id', 'dt'                         => 0 ),
    array( 'db' => 'ds_nota', 'dt'                       => 1 ), 
    array( 'db' => 'customer_nama', 'dt'                 => 2 ), 
    array( 'db' => 'ds_terima_date_time',  'dt'          => 3 ), 
    array( 'db' => 'ds_servis_berkala_date_time',  'dt'  => 4 ),
    array( 
        'db'        => 'ds_servis_berkala_status', 
        'dt'        => 5, 
        'formatter' => function( $d, $row ) { 
            // Ternary Operator
            return ($d == 0) ? "<span class='badge badge-danger'>Sudah Diinfo</span>" : 
            ($d == 1 ? "<span class='badge badge-secondary'>Belum Diinfo</span>" :  
              "<span class='badge badge-danger'>Sudah Diinfo</span>"); 
        } 
    ),
); 

// Include SQL query processing class 
require 'aksi/ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null, "ds_cabang = $cabang && ds_servis_berkala BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' " )
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);