<?php

    $options = include 'include.php';
    
    $search = (!empty($_POST['search'])) ? $_POST['search'] : '';
    $filter = (!empty($_POST['filter'])) ? $_POST['filter'] : '';

?>

<html>
<head>
    <meta charset = 'utf-8'>
    <title>USER PAGE</title>
</head>
<body>

    <h1>LIST OF AVAILABLE TABLES</h1>

    <br>
    
    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">

    <label>SEARCH: </label>
    <input type = 'text' name = 'search' value = "<?php echo (!empty($search)) ? $search : ''; ?>">

    <select name = 'filter'>

    <?php 

        if((!empty($filter) && $filter == 'seats') || empty($filter))
        {
            echo "<option value = 'seats'>SEATS</option>";
            echo "<option value = 'area'>AREA</option>";
        }
        elseif(!empty($filter && $filter == 'area'))
        {
            echo "<option value = 'area'>AREA</option>";
            echo "<option value = 'seats'>SEATS</option>";
        }

    ?>

    </select>

    <input type = 'submit' name = 'filterBTN' value = 'SEARCH'>
    <input type = 'submit' name = 'showAll' value = 'SHOW ALL'>

    </form>

    <a href = 'reserve_table.php'><img src = 'table_layout.jpg' align = 'right'></a>
    
    <?php 
    
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            if(!empty($_POST['filterBTN']) && isset($_POST['filterBTN']))
            {
                $options['query']->filterTables($_POST['search'], $_POST['filter']);
            }
            elseif(!empty($_POST['showAll']) && isset($_POST['showAll']))
            {
                $options['query']->showAllTables(); 
            }
        }
        else
        {   
            $options['query']->showAllTables(); 
        }
       
    ?>

    <br>
    <br>

    <a href = 'admin.php'>ADMIN</a>

</body>
</html>