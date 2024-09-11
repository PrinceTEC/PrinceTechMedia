<?php

require __DIR__ . '/../vendor/autoload.php';
require 'mpesa_config.php';
use Twilio\Rest\Client;

function sendOtp($phoneNumber, $otp) {
    $sid = TWILIO_SID;
    $token = TWILIO_AUTH_TOKEN;
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
                      ->create(
                          $phoneNumber, // To phone number
                          [
                              "body" => "Your verification code is $otp",
                              "from" => TWILIO_PHONE_NUMBER
                          ]
                      );

    return $message->sid;
}

function generateOtp() {
    return rand(100000, 999999); // Generates a 6-digit OTP
}
