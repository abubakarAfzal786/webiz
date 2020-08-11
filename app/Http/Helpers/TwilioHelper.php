<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

trait TwilioHelper
{
    private $token;
    private $sid;
    private $verify_sid;

    /**
     * Set Twilio Credentials
     */
    private function setCredentials()
    {
        $this->token = config('twilio.token');
        $this->sid = config('twilio.sid');
        $this->verify_sid = config('twilio.verify_sid');
    }

    /**
     * @param $number
     * @return bool
     */
    public function sendVerificationSMS($number)
    {
        $this->setCredentials();

        try {
            $twilio = new Client($this->sid, $this->token);
            $twilio->verify->v2->services($this->verify_sid)->verifications->create($number, 'sms');
            return true;
        } catch (TwilioException $e) {
            Log::channel('twilio')->error($e);
        }

        return false;
    }

    /**
     * @param $code
     * @param $number
     * @return bool
     */
    public function verifyWithOTP($code, $number)
    {
        $this->setCredentials();

        try {
            $twilio = new Client($this->sid, $this->token);
            $verification = $twilio->verify->v2->services($this->verify_sid)->verificationChecks->create($code, ['to' => $number]);
            if ($verification->valid) return true;
        } catch (TwilioException $e) {
            Log::channel('twilio')->error($e);
        }

        return false;
    }
}
