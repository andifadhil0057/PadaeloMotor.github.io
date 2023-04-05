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
      a.servis_id, 
      a.servis_kode,
      a.servis_nama,
      a.servis_biaya, 
      a.servis_kategori, 
      a.servis_status,
      a.servis_cabang,
      b.kategori_servis_id,
      b.kategori_servis_nama
    FROM servis a
    LEFT JOIN kategori_servis b ON a.servis_kategori = b.kategori_servis_id
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'servis_id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'servis_id', 'dt'              => 0 ),
    array( 'db' => 'servis_kode', 'dt'            => 1 ), 
    array( 'db' => 'servis_nama', 'dt'            => 2 ), 
    array( 'db' => 'kategori_servis_nama',  'dt'  => 3 ), 
    array( 'db' => 'servis_biaya',      'dt'      => 4 )
); 

// Include SQL query processing class 
require 'aksi/ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null, "servis_status > 0 && servis_cabang = $cabang " )
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);