<?php

namespace App\Http\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

trait IotHelper
{
    /**
     * @param string $method
     * @param string $action
     * @param array $params
     * @return array
     */
    public function IotRequest($method = 'GET', $action = '', $params = [])
    {
        $endpoint = config('other.iot_endpoint') . $action;
        $responseResource = [
            'message' => null,
            'data' => [],
            'status' => false,
        ];

        try {
            $client = new Client();
            $response = $client->request($method, $endpoint, $params);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {
                $content = json_decode($response->getBody(), true) ?? $response->getBody();
                if (isset($content['status']['error']) && $content['status']['error']) {
                    $responseResource['message'] = $content['status']['msg'];
                } else {
                    $responseResource['data'] = $content['data'];
                    $responseResource['status'] = 1;
                }
            } else {
                $responseResource['message'] = 'Something went wrong';
            }
        } catch (GuzzleException $exception) {
            Log::error($exception);
            $responseResource['message'] = 'Something went wrong';
        }

        return $responseResource;
    }

    public function getIotDevices()
    {
        return $this->IotRequest('GET', ('devices'));
    }

    public function getIotDevice($id)
    {
        return $this->IotRequest('GET', ('device/' . $id));
    }

    /**
     * @param $id
     * @return string|null
     */
    public function getIotState($id)
    {
        return $this->IotRequest('GET', ('state/' . $id))['data']['state'] ?? null;
    }

    /**
     * @param $id
     * @return string|null
     */
    public function toggleIotDevice($id)
    {
        return $this->IotRequest('POST', ('toggle/' . $id))['data']['status'] ?? null;
    }

    /**
     * @param $id
     * @return bool
     */
    public function openIotDoor($id)
    {
        return ($this->getIotState($id) != 'on') ? ($this->toggleIotDevice($id) == 'ok') : true;
    }
}
