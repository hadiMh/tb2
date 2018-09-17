<?php
    /* send message functions */
        function sendMessage($chatId, $message, $r)
        {
            $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r;
            file_get_contents($url);
        }

        function sendMessageReplyTo($chatId, $message, $r, $replyTo)
        {
            $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r."&reply_to_message_id=".$replyTo;
            file_get_contents($url);
        }

    /* english and persian numbers transformations */
        function enNumToFa($string) {
            return strtr($string, array('0'=>'۰', '1'=>'۱', '2'=>'۲', '3'=>'۳', '4'=>'۴', '5'=>'۵', '6'=>'۶', '7'=>'۷', '8'=>'۸', '9'=>'۹'));
        }

        function faNumToEn($string) {
            return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9'));
        }

    /* reply markups */
        function returnEMhide() { /* hide the buttom keyboard */
            $rm = array(
                'hide_keyboard' => true
            );
            return json_encode($rm, true);
        }

    /* add a user to the users table */
    function addUserToTable($userId) {
        global $connection;
        global $name, $username;
        global $chatId;

        sendMessage($chatId, "88", returnEMhide());
        /* @bot_status : a number that shows which stage the user is */
        $query = "INSERT INTO users (user_id, username, name, msg, bot_status) ";
        $query .= "VALUES ('$userId', '$username', '$name', '[]', 0)";
        sendMessage($chatId, "99", returnEMhide());
        $result = mysqli_query($connection, $query);
        sendMessage($chatId, "11" , returnEMhide());
        if(!$result) {
            /* should log the error to the txt.log and then run die() function */
            sendMessage($chatId, '00000000'.mysqli_error($connection) ,returnEMhide());
            // die();
        }else {
            
    sendMessage($chatId, "000", returnEMhide());
        }
    }

    /* check if user exist in db. if it doesn't exist it will be created in table with addUserToTable() function*/
    function checkUserExistanceInDB($userId) {
        global $connection;
        global $chatId;

        sendMessage($chatId, "22", returnEMhide());
        $query = "SELECT * FROM users WHERE user_id = '";
        $query .= $userId."'";
        sendMessage($chatId, "33", returnEMhide());
        $result = mysqli_query($connection, $query);
        sendMessage($chatId, "44", returnEMhide());
        if(!$result) {
            /* should log the error to the txt.log and then run die() function */
            sendMessage($chatId, "2" ,returnEMhide());
            // die();
        } else {
            
    sendMessage($chatId, "55", returnEMhide());
        }
        $num_rows = mysqli_num_rows($result);
        if($num_rows === 0) {
            /* no such user exist in users table so create it */
    sendMessage($chatId, "66", returnEMhide());
            addUserToTable($userId);
        } else {
            /* this user already exist in users table so do nothing */
    sendMessage($chatId, "77", returnEMhide());
            return;
        }
    }