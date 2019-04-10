<?php

namespace Forge;


use GuzzleHttp\Client;

class Upload
{
    private $url;
    private $token = null;

    public function __construct($url = "")
    {
        if ($url === "") {
            throw new \Exception("URL不能为空", 500);
        }
        $this->url = $url;
        $this->token = (new Auth($url))->Token();
    }

    /**
     * 上传文件
     * @param $bucket   仓库名
     * @param $objectkey objectkey
     * @param $filename 文件路径
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function iCloud($bucket, $objectkey, $filename)
    {
        $apiStr = "/oss/v2/buckets/{$bucket}/objects/{$objectkey}";
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