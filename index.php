<?php

    include "db.php"; /* connects to the database */
    include "buttons.php";
    include "functions.php";

    $targetGroupId = -1001306017183;
    $adminId = 101863453;

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

    sendMessage($chatId, "0", returnEMhide());
    checkUserExistanceInDB($userId);
    sendMessage($chatId, "-1", returnEMhide());
    if($message === "/start") {
        sendMessageToCurrentUser("به ربات ثبت شکایت و پیشنهاد خوش آمدید.\n این ربات برای ارسال تمامی مشکلات، پیشنهادات و هر مورد ارتباط با بخش معاونت آموزشی دانشگاه ساخته شده است تا تمامی این موارد در کمترین زمان ممکن به مسئولین مربوطه ازسال شود و هر گونه نارضایتی و مشکلی را در کمترین زمان ممکن حل کند.\nبرای استفاده ز ربات میتوانید از دکمه های زیر استفاده کنید.",$main_panel);
    } else if($message == $main_panel[0][0]) {
        sendMessageToCurrentUser("$main_panel[0][0] was clicked.");
    }

    // sendMessageReplyTo($chatId, "hello", returnEMhide(), $messageId);

    // if($userId === 101863453)
    //     sendMessageReplyTo($chatId, "yes admin", returnEMhide(), $messageId);

    // if($chatId === $targetGroupId) {
    //     if($message === "hello") {
    //         sendMessageReplyTo($chatId, "Hi, how you doing?", returnEMhide(), $messageId);
    //     } else if($message === "log") {
    //         sendMessageReplyTo($chatId, "You have had 3 critics at all.", returnEMhide(), $messageId);
    //     }
    // } else {
    //     if($message === "/help") {
    //         sendMessage($chatId, "/help for getting the commands\n".
    //                              "/naghd for sending critic\n", returnEMhide());
    //     }else if($message === "/naghd") {
    //         sendMessageReplyTo($chatId, "برای نظم بیشتر پیام های ارسالی، نقد خود را در یک پبام بنویسید و ارسال کنید. پیام شما مستقیما به اعضای انجمن ارسال میشود.".
    //                                     "\nبرای رسیدگی سریع به نقد های واقعی کاربرانی که پیام های اسپم میفرستند به سرعت بلاک میشوند. اگر بلاک بشوید به شما اعلام میشود تا در جریان باشید.".
    //                                     "\nدر صورتی که فکر میکنید اشتباه بلاک شده اید به ادمین ربات پیام بدهید.", returnEMhide(), $messageId);
    //     } else if($message === "")
    // }