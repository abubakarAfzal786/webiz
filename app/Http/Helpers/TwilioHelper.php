<?php

namespace App\Http\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\CurlClient;
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

        try {
            $twilio = new Client($this->sid, $this->token, $this->sid, null, new CurlClient([CURLOPT_CONNECTTIMEOUT => 0, CURLOPT_TIMEOUT => 0]));
        } catch (ConfigurationException $e) {
            Log::channel('twilio')->error($e);
            $twilio = null;
        }

        return $twilio;
    }

    /**
     * @param $number
     * @return bool
     */
    public function sendVerificationSMS($number)
    {
        try {
            $twilio = $this->setCredentials();
            $twilio->verify->v2->services($this->verify_sid)->verifications->create($number, 'sms');
            return true;
        } catch (TwilioException $e) {
            Log::channel('twilio')->error($e);
        } catch (Exception $exception) {
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
            $twilio = $this->setCredentials();
            $verification = $twilio->verify->v2->services($this->verify_sid)->verificationChecks->create($code, ['to' => $number]);
            if ($verification->valid) return true;
        } catch (TwilioException $e) {
            Log::channel('twilio')->error($e);
        } catch (Exception $exception) {
        }

        return false;
    }
}
