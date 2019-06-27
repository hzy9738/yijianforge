<?php

namespace Forge;

class Compare
{

    private $token = null;
    private $client = null;
    private $url = null;

    public function __construct($url = "")
    {
        if ($url === "") {
            throw new \Exception("URL不能为空", 500);
        }
        $this->url = $url;
        $this->token = (new Auth($url))->Token();
        $this->client = new \GuzzleHttp\Client();
    }

    //模型对比
    public function Model($newobjectName, $oldobjectName, $outobjectname, $bucket = "lvp", $isSvfzip = true, $isModelsDb = true)
    {

        $data = [
            "input" => [
                "a" => [
                    "bucketKey" => $bucket,
                    "objectName" => $newobjectName,
                    "isSvfzip" => $isSvfzip
                ],
                "b" => [
                    "bucketKey" => $bucket,
                    "objectName" => $oldobjectName,
                    "isSvfzip" => $isSvfzip
                ]
            ],
            "output" => [
                "bucketKey" => $bucket,
                "objectName" => $outobjectname,
                "createPropDb" => $isModelsDb
            ]
        ];
        $res = $this->client->request('POST', $this->url . '/job/v1/author-differ',
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


    //转化进度
    public function progress($urn)
    {
        $res = $this->client->request('GET', $this->url . "/job/v1/author-differ/" . $urn,
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