int servoPin = A4;
int servoIdlePos = 0;
int servoDispensePos = 60;
Servo servo;

void setup() {
    Particle.function("dispense", dispenseButton);
    Particle.subscribe("hook-response/poll_twitter", twitterPolled, MY_DEVICES);
    
    servo.attach(servoPin);
    servo.write(servoIdlePos);
}

void loop() {
    Particle.publish("poll_twitter");
    delay(5000);
}

void twitterPolled(const char *name, const char *data) {
    
}

int dispenseButton(String command) {
    if (servo.read() != servoIdlePos) {
        servo.write(servoIdlePos);
        delay(1500);
    }
    for (int i = 0; i < atoi(command); i++) {
        servo.write(servoDispensePos);
        delay(1500);
        servo.write(servoIdlePos);
        delay(1500);
    }
    
    return 1;
}
