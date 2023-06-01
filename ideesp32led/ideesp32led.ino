#include <WiFi.h>
#include <PubSubClient.h>
#include <ArduinoJson.h>

// Configuración de red WiFi
const char* ssid = "adriannegrooo";
const char* password = "789456123";

// Configuración del broker MQTT
const char* mqttServer = "34.133.76.144";
const int mqttPort = 1883;
const char* mqttUsername = "adrianjustiniano";
const char* mqttPassword = "adrian";
const char* ledTopic = "led";

// Pin del LED en el ESP32
const int ledPin = 2;

WiFiClient wifiClient;
PubSubClient mqttClient(wifiClient);

void mqttCallback(char* topic, byte* payload, unsigned int length) {
  // Convertir el payload en una cadena de caracteres
  char message[length + 1];
  memcpy(message, payload, length);
  message[length] = '\0';

  // Analizar el mensaje JSON
  DynamicJsonDocument jsonDoc(256); // Tamaño máximo del JSON
  DeserializationError error = deserializeJson(jsonDoc, message);
  if (error) {
    Serial.print("Error al analizar JSON: ");
    Serial.println(error.c_str());
    return;
  }

  // Obtener el estado del LED del mensaje JSON
  const char* estado = jsonDoc["estado"];

  // Controlar el LED según el estado recibido
  if (strcmp(estado, "ON") == 0) {
    digitalWrite(ledPin, HIGH);  // Encender el LED
    Serial.println("LED encendido");
  } else if (strcmp(estado, "OFF") == 0) {
    digitalWrite(ledPin, LOW);  // Apagar el LED
    Serial.println("LED apagado");
  }
}

void connectToMqtt() {
  while (!mqttClient.connected()) {
    Serial.println("Conectando a MQTT...");

    if (mqttClient.connect("ESP32Client", mqttUsername, mqttPassword)) {
      Serial.println("Conexión exitosa a MQTT");
      mqttClient.subscribe(ledTopic);
    } else {
      Serial.print("Error al conectar a MQTT, código de estado: ");
      Serial.print(mqttClient.state());
      Serial.println(" Retrying in 5 seconds...");
      delay(5000);
    }
  }
}

void setup() {
  Serial.begin(115200);

  pinMode(ledPin, OUTPUT);
  digitalWrite(ledPin, LOW);  // Apagar el LED al inicio

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Conectando a WiFi...");
  }
  Serial.println("Conexión WiFi exitosa");
  Serial.print("Dirección IP: ");
  Serial.println(WiFi.localIP());

  mqttClient.setServer(mqttServer, mqttPort);
  mqttClient.setCallback(mqttCallback);
}

void loop() {
  if (!mqttClient.connected()) {
    connectToMqtt();
  }
  mqttClient.loop();
}
