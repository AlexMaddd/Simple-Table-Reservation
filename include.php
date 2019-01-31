<?php 

    include 'queries.php';
    include 'connection.php';
    include 'reserve.php';
    include 'reserve_data.php';
    $config = include 'db_config.php';

    $conn = new Connection($config['database']);

    return [

        'conn' => $conn->connect(),
        'query' => new Queries($conn->connect()),
        'reserve' => new Reserve($conn->connect())
        
    ];

?>