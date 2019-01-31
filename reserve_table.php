<?php

    $options = include 'include.php';

    if(isset($_GET['table_id']) && !empty($_GET['table_id']))
    {
        $data = $options['query']->getTableData($_GET['table_id']);
        $seats = $data['seats'];
    }
    elseif($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $seats = $_POST['seats'];
        $table_id = $_POST['table_id'];
        unset($_POST['seats']);

        $data = new ReserveData($_POST, $options['conn']);
        $errors = $data->checkErrors();

        ($errors == FALSE) ? $options['reserve']->reserveTable($_POST) :  extract($_POST); // extracts and puts values into variables with names of key, 'reservee' = value

        
    }

?>

<html>
<head>
    <meta charset = 'utf-8'>
    <title>RESERVE YOUR TABLE</title>
</head>
<body>

    <h1>RESERVATION DETAILS</h1>

    <br>

    <?= strtotime("+5 Years", strtotime(date('y-m-d'))); ?>

    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">

    <label>TABLE #: <strong><?php echo (!empty($_GET['table_id'])) ? $_GET['table_id'] : $table_id ; ?></strong></label><br>
    <label>SEATS : <strong><?php echo $seats; ?></strong></label><br><br>

    <label>RESERVEE:</label><br>
    <input type = 'text' name = 'reservee' value = "<?php echo (!empty($reservee)) ? $reservee : ''; ?>">
    <?php echo (!empty($errors['reservee_error'])) ? $errors['reservee_error'] : ""; ?>
    
    <input type = 'hidden' name = 'table_id' value = "<?php echo (!empty($_GET['table_id'])) ? $_GET['table_id'] : $table_id; ?>" >
    <input type = 'hidden' name = 'reservation_made' = value = "<?php echo date('Y-m-d'); ?>">

    <br>
    <br>

    <label>NUMBER OF GUESTS:</label><br>
    <input type = 'number' name = 'number_of_guests' value = "<?php echo (!empty($number_of_guests)) ? $number_of_guests : ''; ?>">
    <?php echo (!empty($errors['guests_error'])) ? $errors['guests_error'] : ''; ?>

    <br>
    <br>

    <label>DATE OF RESERVATION:</label><br>
    <input type = 'date' name = 'date_of_reservation' min = "<?php echo date("Y-m-d"); ?>" max = "<?php echo date("Y-m-d", strtotime("+1 Year", strtotime(date("Y-m-d")))); ?>" value = "<?php echo (!empty($date_of_reservation)) ? $date_of_reservation : ''; ?>">
    <sup><?php echo (!empty($errors['date_error'])) ? $errors['date_error'] : 'RESERVATION ONLY UP TO 1 YEAR IN ADVANCE'; ?></sup>

    <br>
    <br>

    <label>TIME OF RESERVATION:</label><br>
    <input type = 'time' name = 'time_of_reservation'  value = "<?php echo (!empty($time_of_reservation)) ? $time_of_reservation : ''; ?>">
    <sup><?php echo (!empty($errors['time_error'])) ? $errors['time_error'] : ''; ?></sup>

    <input type = 'hidden' name = 'seats' value = "<?php echo $seats; ?>">

    <br>
    <br>

    <input type = 'submit' value = "RESERVE">
    <a href = 'user.php'>BACK</a>

    </form>

</body>
</html>