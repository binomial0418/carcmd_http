#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <base64.h>

#define RELAY_PIN_A  5  // GPIO 5 (D1 on NodeMCU)
#define RELAY_PIN_B  4  // GPIO 4 (D2 on NodeMCU)

const char* ssid = "oppo";
const char* password = "09880";
const char* url = "http://url.com/checkcarboot.php";

void setup() {
  int iCount = 0;
  Serial.begin(115200);
  Serial.println("");

  // 設置繼電器控制腳為輸出模式
  pinMode(RELAY_PIN_A, OUTPUT);
  pinMode(RELAY_PIN_B, OUTPUT);

  // 初始化時關閉繼電器
  digitalWrite(RELAY_PIN_A, HIGH);
  digitalWrite(RELAY_PIN_B, HIGH);

  // 連接 WiFi
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1500);
    Serial.print(".");
    iCount++;
    if (iCount > 20){
      Serial.println("停止連線");
      break;
    }
  }
  if (iCount <= 20){
    Serial.println("WiFi connected");
  } 
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    WiFiClient client;

    // 使用 WiFiClient 和 URL 初始化 HTTPClient
    http.begin(client, url);

    int httpCode = http.GET();  // 發送請求並取得回應代碼

    if (httpCode > 0) {
      String payload = http.getString();  // 取得網頁內容

      // 檢查 "boot" 標籤是否為 "enable"
      if (payload.indexOf("<boot>boot</boot>") != -1) {
        triggerRelays();
        // Serial.println("Boot car....");
      } else {
        // Serial.println("Boot is not enabled.");
      }
    } else {
      Serial.printf("GET failed, error: %s\n", http.errorToString(httpCode).c_str());
    }
    http.end();  // 結束 HTTP 請求
  }
  Serial.println("Entering deep sleep mode...");
  ESP.deepSleep(180e6);  // 定时唤醒 x sec
  Serial.println("Exit deep sleep mode...");
  //delay(60000);  // 每隔60秒檢查一次 
}

void triggerRelays() {
  Serial.println("Engine start");
  send_line(" 準備啟動...");

  //觸發繼電器 A 一秒
  digitalWrite(RELAY_PIN_A, LOW);
  delay(1000);
  digitalWrite(RELAY_PIN_A, HIGH);
  delay(500);
  // 觸發繼電器 B 五秒
  digitalWrite(RELAY_PIN_B, LOW);
  delay(5000);
  digitalWrite(RELAY_PIN_B, HIGH);
  send_line(" 啟動中...");

}

void send_line(String msg) {
  WiFiClient client;
  HTTPClient http;

  String encodedString = base64::encode(msg);
  String url = "http://url.com/sendtoline_car.php?msg=" + encodedString;
  http.begin(client, url);

  int httpCode = http.GET();

  if (httpCode > 0) {
    String payload = http.getString();
    Serial.println(httpCode);
    Serial.println(payload);
  } else {
    Serial.println("Error on HTTP request");
  }

  http.end();
}
