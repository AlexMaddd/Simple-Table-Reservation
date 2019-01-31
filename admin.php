<?php

    $options = include 'include.php';

?>

<html>
<head>
    <meta charset = 'utf-8'>
    <title>ADMIN PAGE</title>
</head>
<body>

    <h1>LIST OF RESERVATIONS</h1>

    <br>
    <br>

    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">

    <label>SEARCH RESERVEE: </label>
    <input type = "text" name = "reservee" value = "<?php echo (!empty($search)) ? $search : ''; ?>">

    <br>
    <br>

    <label>SEARCH DATE: </label>
    <input type = 'date' name = 'reserve_date' value = "<?php echo (!empty($date)) ? $date : '';?>">

    <br>
    <br>


    <input type = 'submit' value = 'SEARCH'>
    <input type = 'submit' name = 'showAll' value = "SHOW ALL">

    </form>

    <br>

    <br>
    <br>

    <?php
    
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            array_filter($_POST);
            $filter = (key($_POST));

            if(isset($_POST['reservee']) && !empty($_POST['reservee']))
            {
                $options['query']->filterReserved($_POST['reservee'], $filter);
            }
            elseif(isset($_POST['reserve_date']) && !empty($_POST['reserve_date']))
            {
                $options['query']->filterReserved($_POST['reserve_date'], $filter);
            }
            elseif(isset($_POST['showAll']))
            {
                $options['query']->showAllReserved();
            }
            elseif(empty($_POST['reservee']))
            {
                $options['query']->showAllReserved();
            }
        }
        else
        {   
            $options['query']->showAllReserved();
        }

    ?>

    <br>

    <a href = "user.php">USER</a>

</body>
</html>