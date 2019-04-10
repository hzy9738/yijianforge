<?php

namespace Forge;

class Merge
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

    //模型合并
    public function Model($input, $outobjectname)
    {
        $data = [
            "input" => $input,
            "output" => [
                "bucketKey" => "lvp",
                "objectName" => $outobjectname
            ]
        ];
        $res = $this->client->request('POST', $this->url . '/job/v1/author-merger',
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


    //合并进度
    public function progress($urn)
    {
        $res = $this->client->request('GET', $this->url . "/job/v1/author-merger/" . $urn,
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