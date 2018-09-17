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
        
        function returnEM($buttomArray) { // create a basic encoded markaup for givven buttoms
            $rm = array(
                'keyboard' => $buttomArray,
                'one_time_keyboard' => false,
                'resize_keyboard' => true,
                'selective' => true
            );
            return json_encode($rm, true);
        }

    /* Database CRUD functions */
        /* add a user to the users table */
        function addUserToTable($userId) {
            global $connection;
            global $name, $username;

            /* @bot_status : a number that shows which stage the user is */
            $query = "INSERT INTO users (user_id, username, name, msgs, bot_status) ";
            $query .= "VALUES ('$userId', '$username', '$name', '[]', 0)";
            $result = mysqli_query($connection, $query);
            if(!$result) {
                /* should log the error to the txt.log and then run die() function */
                // die();
            }else {
                
            }
        }

        /* check if user exist in db. if it doesn't exist it will be created in table with addUserToTable() function*/
        function checkUserExistanceInDB($userId) {
            global $connection;

            $query = "SELECT * FROM users WHERE user_id = '";
            $query .= $userId."'";
            $result = mysqli_query($connection, $query);
            if(!$result) {
                /* should log the error to the txt.log and then run die() function */
                // die();
            } else {
                
            }
            $num_rows = mysqli_num_rows($result);
            if($num_rows === 0) {
                /* no such user exist in users table so create it */
                addUserToTable($userId);
            } else {
                /* this user already exist in users table so do nothing */
                return;
            }
        }
    /* change user status that where the user is in bots flow */
    function setUserColumnData($userId, $column, $data) {
        global $connection;

        $query = "UPDATE users SET ";
        $query .= "$column = '$data' ";
        $query .= "WHERE user_id = '$userId' ";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            // log to the log file
            // die()
        }
    }

    function getUserColumnData($userId, $column) {
        global $connection;

        $query = "SELECT '$column' FROM users ";
        $query .= "WHERE user_id = '$userId' ";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            // log to log file
            sendMessage($userId, mysqli_error($result), returnEMhide());
            // die()
        }
        $data = mysqli_fetch_assoc($result);
        sendMessage($userId, print_r($data, true), returnEMhide());
        return $data[$column];
    }