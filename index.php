<?php

    // include "db.php"; /* connects to the database */
    include "functions.php";

    $botToken = getenv('BOT2TOKEN'); // 621283295:AAEo9rqqrAz_JJllkfGJ1K0dm1aIBCxgl4E
    $webSite = "https://api.telegram.org/bot" . $botToken;

    /* the json recieves from the telegram api */
    $update = file_get_contents("php://input");
    $update = json_decode($update, TRUE);
     
    /* save the recieved json data seperately */
    $name = $update['message']['from']['first_name'];
    $userId = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];

    sendMessage($chatId, "hello", returnEMhide());