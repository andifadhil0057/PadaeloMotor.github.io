<?php 
include 'aksi/koneksi.php';
$cabang = $_GET['cabang'];

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
      a.kendaraan_id, 
      a.kendaraan_nopol,
      a.kendaraan_pemilik, 
      a.kendaraan_merek,  
      a.kendaraan_jenis, 
      a.kendaraan_cabang,
      b.customer_id,
      b.customer_nama,
      b.customer_tlpn
    FROM kendaraan a
    LEFT JOIN customer b ON a.kendaraan_pemilik = b.customer_id
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'kendaraan_id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'kendaraan_id', 'dt'         => 0 ),
    array( 'db' => 'customer_nama', 'dt'      => 1 ), 
    array( 'db' => 'customer_tlpn',  'dt'     => 2 ), 
    array( 'db' => 'kendaraan_merek',    'dt' => 3 ),
    array( 'db' => 'kendaraan_nopol',    'dt' => 4 ), 
    array( 'db' => 'kendaraan_jenis',  'dt'   => 5 )
); 

// Include SQL query processing class 
require 'aksi/ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null, "kendaraan_cabang = $cabang" )
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);