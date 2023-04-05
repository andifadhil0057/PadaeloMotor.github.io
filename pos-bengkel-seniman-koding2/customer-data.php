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
$table = 'customer'; 

 
// Table's primary key 
$primaryKey = 'customer_id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'customer_id', 'dt'              => 0 ),
    array( 'db' => 'customer_nama', 'dt'            => 1 ), 
    array( 'db' => 'customer_tlpn', 'dt'            => 2 ), 
    array( 'db' => 'customer_count_invoice',  'dt'  => 3 ), 
    array( 'db' => 'customer_count_servis',   'dt'  => 4 ),
    array( 
        'db'        => 'customer_status', 
        'dt'        => 5, 
        'formatter' => function( $d, $row ) { 
            return ($d == 1)?'Aktif':'Tidak Aktif'; 
        } 
    ) 
); 

// Include SQL query processing class 
require 'aksi/ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, null, "customer_id > 1 && customer_tlpn > 0 && customer_cabang = $cabang " )
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);