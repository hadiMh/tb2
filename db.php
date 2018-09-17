<?php
    $connection = mysqli_connect(getenv('BOT2DBSERVER'), getenv('BOT2DBUSERNAME'), getenv('BOT2DBPASSWORD'), getenv('BOT2DBNAME'), '3306');
    if(!$connection) {
        
    }