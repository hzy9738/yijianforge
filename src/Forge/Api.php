<?php

namespace Forge;


use GuzzleHttp\Client;

class Api
{
    public $url;
    public $token = null;

    public function __construct($url = null)
    {
        if (empty($url)) {
            throw new \Exception("URL不能为空", 500);
        }
        $this->url = $url;
        $this->token = (new Auth($url))->Token();

    }

    public function Post($body, $apiStr, $token = null)
    {

        $client = new \GuzzleHttp\Client();
        if (is_null($token)) {
            $res = $client->request('POST', $this->url . $apiStr,
                [
                    'form_params' => $body,
                    'verify' => false,
                ]
            );
        } else {
            $res = $client->request('POST', $this->url . $apiStr,
                [
                    'form_params' => $body,
                    'verify' => false,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
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
    public function PostJson($body, $apiStr)
    {
        $client = new \GuzzleHttp\Client();

        $res = $client->request('POST', $this->url . $apiStr,
            [
                'json' => $body,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    "Content-Type" => "application/json",
                    'x-ads-force' => true
                ]
            ]
        );

        $data = $res->getBody()->getContents();
        return json_decode($data);

    }


    public function Get($apiStr, $body = [], $token = null)
    {
        $client = new \GuzzleHttp\Client();
        if (is_null($token)) {
            $res = $client->request('POST', $this->url . $apiStr,
                [
                    'form_params' => $body,
                ]
            );
        } else {
            $res = $client->request('POST', $this->url . $apiStr,
                [
                    'json' => $body,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        "Content-Type" => "application/json",
                        'x-ads-force' => true
                    ]
                ]
            );
        }

        $data = $res->getBody();

        return json_decode($data);

    }


    //上传文件
    public function Upload($apiStr, $filename)
    {
        $client = new \GuzzleHttp\Client();
        $url = $this->url . $apiStr;
        $opts = [
            // auth
            'body' => fopen($filename, "r"),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/binary'
            ],
        ];
        $response = $client->request('PUT', $url, $opts);
        $data = $response->getBody();
        return json_decode($data);
    }


}