<?php

    return 
    [
        'table' => 'reserve_list',
        'primaryKey' => 'reserve_id',
        'foreignKey' => 'table_id',
        'openingTime' => date("H:i", strtotime('9:00')) ,
        'lastReserve' => date("H:i", strtotime('20:00')),
        'fillables' => ['reservee', 'table_id', 'reservation_made', 'number_of_guests', 'reserve_date', 'reserve_time']
    ];

?>