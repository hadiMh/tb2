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

        /* get any data from a user row */
        function getUserColumnData($userId, $column) {
            global $connection;

            $query = "SELECT $column FROM users ";
            $query .= "WHERE user_id = '$userId' ";
            $result = mysqli_query($connection, $query);
            if(!$result) {
                // log to log file
                // die()
            }
            $data = mysqli_fetch_assoc($result);

            return $data[$column];
        }

        function getUserMsg($userId) {
            global $connection;

            $query = "SELECT msgs FROM users ";
            $query .= "WHERE user_id = $userId";
            $result = mysqli_query($connection, $query);

            if(!$result) {
                // log the error in the log file
                // die();
            }

            $row = mysqli_fetch_assoc($result);
            return $row['msgs'];
        }

        function saveUserMsg($userId, $msgText, $msgSubject) {
            global $connection;

            $timezone  = 4.5;
            $shamsiData = gregorian_to_jalali(date("Y"),date("m"),date("j"));
            $now_date_time = $shamsiData + gmdate(" H:i:s", time() + 3600*($timezone+date("I"))); 
            $sampleJson = '{"subject" : "'.$msgSubject.'","text" : "'.$msgText.'","date" : "'.$now_date_time.'","status" : "0"}'; 

            $msgsJson = getUserMsg($userId);
            $msgsJson = substr($msgsJson, 0, -1);
            if(strlen($msgsJson) > 5) {
                $msgsJson .= ',';
            }
            $msgsJson .= $sampleJson;
            $msgsJson .= "]";
            $msgsJson = str_replace("\t","",$msgsJson);
            $msgsJson = str_replace("\n","",$msgsJson);
            $query = "UPDATE users SET ";
            $query .= "msgs = \"".mysqli_real_escape_string($connection, $msgsJson)."\" ";
            $query .= "WHERE user_id = '$userId'";
            $result = mysqli_query($connection, $query);
            if(!$result) {
                // log the error in the log file
                // die();
            }
        }

    /* data converting from gregorian to shamsi */
        function gregorian_to_jalali($gy,$gm,$gd,$mod=''){
            $g_d_m=array(0,31,59,90,120,151,181,212,243,273,304,334);
            if($gy>1600){
                $jy=979;
                $gy-=1600;
            }else{
                $jy=0;
                $gy-=621;
            }
            $gy2=($gm>2)?($gy+1):$gy;
            $days=(365*$gy) +((int)(($gy2+3)/4)) -((int)(($gy2+99)/100)) +((int)(($gy2+399)/400)) -80 +$gd +$g_d_m[$gm-1];
            $jy+=33*((int)($days/12053)); 
            $days%=12053;
            $jy+=4*((int)($days/1461));
            $days%=1461;
            if($days > 365){
                $jy+=(int)(($days-1)/365);
                $days=($days-1)%365;
            }
            $jm=($days < 186)?1+(int)($days/31):7+(int)(($days-186)/30);
            $jd=1+(($days < 186)?($days%31):(($days-186)%30));
            return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd;
        }
           
           
        function jalali_to_gregorian($jy,$jm,$jd,$mod=''){
            if($jy>979){
                $gy=1600;
                $jy-=979;
            }else{
                $gy=621;
            }
            $days=(365*$jy) +(((int)($jy/33))*8) +((int)((($jy%33)+3)/4)) +78 +$jd +(($jm<7)?($jm-1)*31:(($jm-7)*30)+186);
            $gy+=400*((int)($days/146097));
            $days%=146097;
            if($days > 36524){
                $gy+=100*((int)(--$days/36524));
                $days%=36524;
                if($days >= 365)$days++;
            }
            $gy+=4*((int)($days/1461));
            $days%=1461;
            if($days > 365){
                $gy+=(int)(($days-1)/365);
                $days=($days-1)%365;
            }
            $gd=$days+1;
            foreach(array(0,31,(($gy%4==0 and $gy%100!=0) or ($gy%400==0))?29:28 ,31,30,31,30,31,31,30,31,30,31) as $gm=>$v){
                if($gd<=$v)break;
                    $gd-=$v;
            }
            return($mod=='')?array($gy,$gm,$gd):$gy.$mod.$gm.$mod.$gd; 
        }