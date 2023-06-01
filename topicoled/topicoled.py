import time
import random
import paho.mqtt.client as mqtt

# Configuración del cliente MQTT
broker_host = "34.133.76.144"
broker_port = 1883
username = "adrianjustiniano"
password = "adrian"
led_topic = "led"

# Crear instancia del cliente MQTT
client = mqtt.Client()

# Configurar las credenciales de autenticación
client.username_pw_set(username, password)

# Función de conexión
def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Conexión exitosa al broker MQTT")
    else:
        print("Error al conectar al broker MQTT, código de resultado: " + str(rc))

# Función de publicación
def publish_message():
    # Generar un valor aleatorio para el estado del LED
    led_state = random.choice(["ON", "OFF"])

    # Publicar el estado del LED en el tópico correspondiente
    client.publish(led_topic, led_state)
    print("Mensaje publicado: " + led_state)

# Función de suscripción
def on_message(client, userdata, msg):
    if msg.topic == led_topic:
        print("Mensaje recibido en el tópico " + msg.topic + ": " + str(msg.payload.decode()))

# Configurar los controladores de eventos
client.on_connect = on_connect
client.on_message = on_message

# Conectar al broker MQTT
client.connect(broker_host, broker_port)

# Iniciar el bucle de eventos
client.loop_start()

# Publicar mensajes cada 5 segundos
try:
    while True:
        publish_message()
        time.sleep(5)
except KeyboardInterrupt:
    pass

# Detener el cliente MQTT
client.loop_stop()
client.disconnect()
