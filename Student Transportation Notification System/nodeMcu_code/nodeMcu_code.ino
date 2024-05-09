const int buttonPin1 = 10; // Pin for Button 1
const int buttonPin2 = 9; // Pin for Button 2

void setup() {
  Serial.begin(9600);
  pinMode(buttonPin1, INPUT_PULLUP); // Internal pull-up resistor for Button 1
  pinMode(buttonPin2, INPUT_PULLUP); // Internal pull-up resistor for Button 2
}

void loop() {
  // Check if Button 1 is pressed
  if (digitalRead(buttonPin1) == LOW) {
    Serial.println("Button 1 pressed! Hello, world!");
    delay(1000); // Add a small delay to debounce the button
  }

  // Check if Button 2 is pressed
  if (digitalRead(buttonPin2) == LOW) {
    Serial.println("Button 2 pressed! Greetings!");
    delay(1000); // Add a small delay to debounce the button
  }
}
