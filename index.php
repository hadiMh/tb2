<?php

    // include "db.php"; /* connects to the database */
    include "functions.php";

    $botToken = getenv('BOT2TOKEN');
    $webSite = "https://api.telegram.org/bot" . $botToken;

    /* the json recieves from the telegram api */
    $updateJson = file_get_contents("php://input");
    $update = json_decode($updateJson, TRUE);
     
    /* save the recieved json data seperately */
    $name = $update['message']['from']['first_name'];
    $userId = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];

    $str1 = sendMessage($chatId, "hello", returnEMhide(), $updateJson);
    sendMessage($chatId, print_r($str1, true), returnEMhide());
    sendMessage($chatId, print_r($update, true), returnEMhide());