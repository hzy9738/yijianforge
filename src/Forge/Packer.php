<?php

namespace Forge;


class Packer
{
    private $token = null;
    private $url = null;
    private $client = null;

    public function __construct($url = "")
    {
        if ($url === "") {
            throw new \Exception("URL不能为空", 500);
        }
        $this->url = $url;
        $this->token = (new Auth($url))->Token();
        $this->client = new \GuzzleHttp\Client();

    }


    //packer 打包成svfzip
    public function SvfZip($objectName, $outputName, $bucket = "lvp")
    {
        $data = [
            "input" => [
                "bucketKey" => $bucket,
                "objectName" => $objectName,
            ],
            "output" => [
                "bucketKey" => $bucket,
                "objectName" => $outputName,
            ]
        ];
        $res = $this->client->request('POST', $this->url . '/job/v1/toolkit-packer',
            [
                'json' => $data,
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


    //打包进度
    public function progress($objectId)
    {

        $res = $this->client->request('GET', $this->url . "/job/v1/toolkit-packer/" . $objectId,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    "Content-Type" => "application/json"
                ]
            ]
        );

        $data = $res->getBody();

        return json_decode($data);

    }

}