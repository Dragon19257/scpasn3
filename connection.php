<?php

    include "credentials.php";
    
    //connection object (connects to the database)
    $connection = new mysqli("localhost", $user, $pw, $db);
    
    //select all records from table scp
    $records = $connection->prepare("select * from scp");
    
    //run the command
    $records->execute();
    
    //save results of above command into a variable
    $result = $records->get_result();

?>