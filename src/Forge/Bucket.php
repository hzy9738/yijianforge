<?php

namespace Forge;


class Bucket
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

    //仓库列表
    public function lists()
    {
        $res = $this->client->request('GET', $this->url . "/oss/v2/buckets",
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

    //仓库详情
    public function detail($bucket)
    {
        $res = $this->client->request('GET', $this->url . "/oss/v2/buckets/" . $bucket . '/details',
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


    /*
     * 添加仓库
     * bucket 仓库名
     * policy 属性
     */
    public function add($bucket, $policy = null)
    {
        $data = [
            "bucketKey" => $bucket,
            "policyKey" => is_null($policy) ? "persistent" : $policy
        ];
        $res = $this->client->request('POST', $this->url . '/oss/v2/buckets',
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

    /*
    * 删除仓库
    * bucket 仓库名
    */
    public function delete($bucket)
    {

        $res = $this->client->request('DELETE', $this->url . '/oss/v2/buckets/' . $bucket,
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


    /*
  * 删除文件
  * bucket    仓库名
  * $filename 文件名
  */
    public function deletefile($bucket, $filename)
    {

        $res = $this->client->request('DELETE', $this->url . "/oss/v2/buckets/{$bucket}/objects/{$filename}",
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