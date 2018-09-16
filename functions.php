<?php

    function sendMessage($chatId, $message, $r)
    {
        $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r;
        file_get_contents($url);
        return $url;
    }

    function sendMessageReplyTo($chatId, $message, $r, $replyTo)
    {
        $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r."&reply_to_message_id=".$replyTo;
        file_get_contents($url);
        return $url;
    }

    /* change the english numbers to the persian numbers */
    function enNumToFa($string) {
        return strtr($string, array('0'=>'۰', '1'=>'۱', '2'=>'۲', '3'=>'۳', '4'=>'۴', '5'=>'۵', '6'=>'۶', '7'=>'۷', '8'=>'۸', '9'=>'۹'));
    }

    /* change the persian numbers to the english numbers */
    function faNumToEn($string) {
        return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9'));
    }

    function returnEMhide() { /* hide the buttom keyboard */
        $rm = array(
            'hide_keyboard' => true
        );
        return json_encode($rm, true);
    }