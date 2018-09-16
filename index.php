<?php

    // include "db.php"; /* connects to the database */
    include "functions.php";

    $targetGroupId = -1001306017183;

    $botToken = getenv('BOT2TOKEN');
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
    $messageId = $update["message"]["message_id"];

    // sendMessageReplyTo($chatId, "hello", returnEMhide(), $messageId);

    // if($userId === 101863453)
    //     sendMessageReplyTo($chatId, "yes admin", returnEMhide(), $messageId);

    if($chatId === $targetGroupId) {
        if($message === "hello") {
            sendMessageReplyTo($chatId, "Hi, how you doing?", returnEMhide(), $messageId);
        }
    }

    sendMessage($chatId, print_r($update, true), returnEMhide());

    sendMessage($chatId, "boo", returnEMhide());