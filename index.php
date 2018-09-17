<?php
    include "db.php"; /* connects to the database */
    include "buttons.php";
    include "functions.php";

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

    /* adds the new users info to the users table */
    checkUserExistanceInDB($userId);

    /* check if user is in a bot status */
    $userBotStatus = getUserColumnData($userId, "bot_status");
    if($userBotStatus === 1) {
        sendMessage($chatId, "پیام شما با موفقیت ارسال شد. در اولین فرصت بررسی شده و به شما اطلاع داده میشود.", returnEM($main_panel));
        sendMessage(151553837, $message, returnEMhide());
    }

    if($message === "/start") {
        sendMessage($chatId, "به ربات ثبت شکایت و پیشنهاد خوش آمدید.\n این ربات برای ارسال تمامی مشکلات، پیشنهادات و هر مورد ارتباط با بخش معاونت آموزشی دانشگاه ساخته شده است تا تمامی این موارد در کمترین زمان ممکن به مسئولین مربوطه ازسال شود و هر گونه نارضایتی و مشکلی را در کمترین زمان ممکن حل کند.\nبرای استفاده ز ربات میتوانید از دکمه های زیر استفاده کنید.", returnEM($main_panel));
    } else if($message === $main_panel[0][0]) {
        setUserColumnData($userId, "bot_status", 1);
        sendMessage($chatId, "پیام خود را در قالب یک پیام ارسال کنید.", returnEMhide());
    } else if($message === $main_panel[0][1]) {
        sendMessage($chatId, $main_panel[0][1]." was clicked.", returnEMhide());
    } else if($message === $main_panel[0][2]) {
        sendMessage($chatId, $main_panel[0][2]." was clicked.", returnEMhide());
    } else if($message === $main_panel[1][0]) {
        sendMessage($chatId, $main_panel[1][0]." was clicked.", returnEMhide());
    } else if($message === $main_panel[1][1]) {
        sendMessage($chatId, $main_panel[1][1]." was clicked.", returnEMhide());
    } else if($message === $main_panel[1][2]) {
        sendMessage($chatId, $main_panel[1][2]." was clicked.", returnEMhide());
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