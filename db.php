<?php
    $connection = mysqli_connect(getenv('BOT2DBSERVER'), getenv('BOT2DBUSERNAME'), getenv('BOT2DBPASSWORD'), getenv('BOT2DBNAME'), '3306');
    // var_dump(function_exists('mysqli_connect'));
    if($connection) {
        sendMessage($chatId, "database connection was successfull!", returnEMhide());
    } else {
        sendMessage($chatId, "database connection failed!", returnEMhide());
    }