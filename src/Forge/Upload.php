<?php

namespace Forge;


use GuzzleHttp\Client;

class Upload
{
    private static $url = "http://192.168.1.214:8000/";


    //上传文件
    public static function iCloud($apiStr, $token, $filename)
    {
        $client = new Client();
        $url = self::$url . $apiStr;
        try {
            $opts = [
                'body' => new \SplFileObject($filename),
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'verify' => false,
                    'Content-Type' => 'application/binary'
                ],
            ];
            $response = $client->request('PUT', $url, $opts);
            $data = $response->getBody();
        } catch (\Exception $e) {
            $data = $e->getMessage();
        }
        return json_decode($data);
    }

}