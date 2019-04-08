<?php

namespace Forge;


use GuzzleHttp\Client;

class Upload
{
    private $url;
    private $token = null;

    public function __construct($url = null)
    {
        if (is_null($url)) {
            return "url不能为空";
        }
        $this->url = $url;
        $this->token = Auth::getInstance()->Token();
    }

    //上传文件
    public function iCloud($apiStr, $filename)
    {
        $client = new Client();
        $url = $this->url . $apiStr;
        try {
            $opts = [
                'body' => new \SplFileObject($filename),
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
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