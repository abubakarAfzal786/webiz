<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Log;

trait FCMHelper
{
    /**
     * @param array|string $tokens
     * @param array $data
     * @param array $extraData
     * @return bool
     */
    public function sendPush($tokens, $data, $extraData = [])
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

//        $data = [
//            'title' => 'title',
//            'body' => 'body of message.',
//            'icon' => 'myIcon',
//            'sound' => 'mySound'
//        ];

//        $extraData = ["message" => $data, "moredata" => 'dd'];

        $extraData['message'] = $data;
        $fcmNotification = [
            'notification' => $data,
            'data' => $extraData
        ];

        if (is_array($tokens)) {
            $fcmNotification['registration_ids'] = $tokens;
        } else {
            $fcmNotification['to'] = $tokens;
        }

        $headers = [
            'Authorization: key=' . config('other.fcm_access_key'),
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        $resDecoded = json_decode($result);
        $success = ($resDecoded && $resDecoded->success);
        if (!$success) Log::channel('push')->error($result);

        return (bool)$success;
    }
}