<?php
require("ssp.php");

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'view_ürünleriGetir';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'ad',  'dt' => 1 ),
    array( 'db' => 'etiket',   'dt' => 2 ),
    array( 'db' => 'kategori',   'dt' => 3 ),
    array( 'db' => 'anaKategoriAd',   'dt' => 4 ),
    array( 'db' => 'id', 'dt' => 5 ,"formatter"=> function($data){
        return '<button type="button" id="'.$data.'" name="blink-button" class="btn btn-block btn-outline-danger btn-lg">'
        .'<i class="fas fa-lightbulb"></i></button>';
    })
);

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '1234',
    'db'   => 'envanter',
    'host' => 'localhost'
    // ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>