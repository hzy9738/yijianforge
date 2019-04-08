<?php

namespace Forge;

class Auth
{
    static private $instance;

    private $token;

    public function __construct($url = null)
    {

        $data = [
            "client_id" => "1u1o7f0vf5nsvcAQ20AribYYkcqciiOH",
            "client_secret" => "LGqolbiQSQnas3j4",
            "grant_type" => "client_credentials",
            "scope" => "data:white",
        ];

        $this->token = (new Api($url))->Post($data, "/authentication/v1/authenticate");
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