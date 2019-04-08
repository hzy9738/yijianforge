<?php
namespace Forge;


use GuzzleHttp\Client;

class Api
{
    private static $url = "http://192.168.1.214:8000/";

    public static function Post($body, $apiStr, $token = null)
    {
        $client = new \GuzzleHttp\Client();
        if (is_null($token)) {
            $res = $client->request('POST', self::$url . $apiStr,
                [
                    'form_params' => $body,
                    'verify' => false,
                ]
            );
        } else {
            $res = $client->request('POST', self::$url . $apiStr,
                [
                    'form_params' => $body,
                    'verify' => false,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        "Content-Type" => "application/json",
                        'x-ads-force' => true
                    ]
                ]
            );
        }
        $data = $res->getBody()->getContents();
        return json_decode($data);

    }


    //
    public static function PostJson($body, $apiStr, $token = null)
    {
        $client = new \GuzzleHttp\Client();
        if (is_null($token)) {
            $res = $client->request('POST', self::$url . $apiStr,
                [
                    'form_params' => $body,
                ]
            );
        } else {
            $res = $client->request('POST', self::$url . $apiStr,
                [
                    'json' => $body,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        "Content-Type" => "application/json",
                        'x-ads-force' => true
                    ]
                ]
            );
        }
        $data = $res->getBody()->getContents();
        return json_decode($data);

    }


    public static function Get($apiStr, $token = null, $body = [])
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', self::$url . $apiStr,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    "Content-Type" => "application/json"
                ]
            ]
        );

        $data = $res->getBody();

        return json_decode($data);

    }


    //上传文件
    public static function Upload($apiStr, $token, $filename)
    {
        $client = new \GuzzleHttp\Client();
        $url = self::$url . $apiStr;
        $opts = [
            // auth
            'body' => fopen($filename, "r"),
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/binary'
            ],
        ];
        $response = $client->request('PUT', $url, $opts);
        $data = $response->getBody();
        return json_decode($data);
    }


}