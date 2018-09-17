<?php
function sendMessage($chatId, $message, $r)
{
    $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r;
    file_get_contents($url);
}

    $connection = mysqli_connect(getenv('BOT2DBSERVER'), getenv('BOT2DBUSERNAME'), getenv('BOT2DBPASSWORD'), getenv('BOT2DBNAME'), '3306');
    // var_dump(function_exists('mysqli_connect'));
    if(!$connection) {
        sendMessage($chatId, "database connection failed!");
    }else {
        sendMessage($chatId, "database connection successful!");
    }