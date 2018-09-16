<?php
    $connection = mysqli_connect(getenv('BOT2DBSERVER'), getenv('BOT2DBUSERNAME'), getenv('BOT2DBPASSWORD'), getenv('BOT2DBTABLE'), '3306');
    // var_dump(function_exists('mysqli_connect'));
    if(!$connection) {
        echo "Database connection failed. shittt!";
    }