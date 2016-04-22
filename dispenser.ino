int servoPin = A4;
int servoIdlePos = 0;
int servoDispensePos = 180;
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
    for (int i = 0; i < atoi(command); i++) {
        switch (servo.read()) {
            case 0:
                servo.write(servoDispensePos);
                break;
            case 180:
            default:
                servo.write(servoIdlePos);
                break;
        }
        delay(3500);
    }
    
    return 1;
}