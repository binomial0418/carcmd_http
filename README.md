1.car_cmd_http.ino for ESP8266，定時查詢checkcarboot.php取得結果判斷是否要觸發動車輛事件。<br>
2.callcarboot.php，設定汽車啟動的網頁，輸入密碼後呼叫callcarboot.php寫入一個汽車啟動的事件進入資料庫。<br>
3.esp8266判斷要啟動車輛時，透過觸發連結的繼電器去控制車輛遙控鑰匙，再讓汽車遙控鑰匙發出啟動車輛的訊號，解此發動車輛。<br>
