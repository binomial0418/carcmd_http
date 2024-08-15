<?php
   /**
    *利用WS傳送LINE 
    *參數：msg為訊息內容，請先做base64編碼
    *呼叫範例：http://url.com/sendtoline_car.php?msg=QlZCLTc5ODDllZ/li5U=
    */
   $msg = $_GET['msg'];
   $msg =  base64url_decode($msg);
   //echo $msg;
   $sts = false;
   $i = 0;
   while ($i < 10){
      $sts = send_line_msg($msg);
      if ($sts == false){
         sleep(1);
         $sts = send_line_msg($msg);
      }else{
         break;
      }
      $i = $i+1;
   }
   if ($sts == false){
      echo '傳送失敗，重新傳送';
   }else{
      echo '傳送成功';
   }
   
   /**
    * Base64 decode
    */
   function base64url_decode($data) {
     return base64_decode(str_pad(strtr($data, '-_', '+/'), 
      strlen($data) % 4, '=', STR_PAD_RIGHT));                   
   }                                                                                                                                                                            
   /**
    * 傳送line訊息並回傳是否成功
    */
   function send_line_msg($message){
      $time = date("Y/m/d H:i:s");
      $message = $message.' - '.$time;
      $headers = array(
            'Content-Type: multipart/form-data',
            'Authorization: Bearer 填上你自己的token'
         );
      $message = array(
               'message' => $message
               );
      $ch = curl_init();
      curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_exec($ch);
      $info = curl_getinfo($ch);
      curl_close($ch);
      //echo $info['http_code'];
      if ($info['http_code'] == '200' ) {
         //echo 'ok';
         return true;
      }
      else {
         //echo 'error';	 
         return false;
      }
   }
?>
