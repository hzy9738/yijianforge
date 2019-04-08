<?php

namespace Forge;

class Auth
{
    private static $instance;

    private $token;

    public function __construct($url = null)
    {
        if(empty($url)){
            throw new \Exception("URL不能为空", 500);
        }
        $data = [
            "client_id" => "1u1o7f0vf5nsvcAQ20AribYYkcqciiOH",
            "client_secret" => "LGqolbiQSQnas3j4",
            "grant_type" => "client_credentials",
            "scope" => "data:white",
        ];

        $client = new \GuzzleHttp\Client();

        $res = $client->request('POST', $url . "/authentication/v1/authenticate",
            [
                'form_params' => $data,
                'verify' => false,
            ]
        );

        $data = $res->getBody()->getContents();
        $this->token = json_decode($data);
    }

    private function __clone()
    {
    }

    static public function getInstance()
    {
        //判断$instance是否是Auth的对象
        //没有则创建
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function Token()
    {
        return $this->token;
    }

    //$hi = Auth::getInstance();
    //$token = $hi -> Token();

}