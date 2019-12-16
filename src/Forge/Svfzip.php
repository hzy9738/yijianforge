<?php

namespace Forge;


class Svfzip
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

    //转化成.svfzip
    public function iCloud($urn, $filename)
    {
        $data = [
            "input" => [
                "urn" => base64_encode($urn),
                "compressedUrn" => false,
                "rootFilename" => $filename
            ],
            "output" => [
                "formats" => [
                    [
                        "type" => "svf",
                        "views" => [
                            "2d",
                        ]
                    ]
                ]
            ]
        ];
        return $this->forge->PostJson($data, 'modelderivative/v2/designdata/job', $this->token);
    }

    /**
     * rvt模型 转化成.svfzip
     * @param $objectId  urn
     * @param $filename 文件路径
     * @param $options 参数
     */
    public function Model($objectId, $filename, $options = [])
    {
        $data = [
            "input" => [
                "urn" => base64_encode($objectId),
                "compressedUrn" => false,
                "rootFilename" => $filename
            ],
            "output" => [
                "formats" => [
                    [
                        "type" => "svf",
                        "features" => $options,
                        "views" => [
                        ]
                    ]
                ]
            ]
        ];
        $res = $this->client->request('POST', $this->url . '/modelderivative/v2/designdata/job',
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

    //图纸转化成.svfzip
    public function Draw($urn, $filename)
    {
        $data = [
            "input" => [
                "urn" => base64_encode($urn),
                "compressedUrn" => false,
                "rootFilename" => $filename
            ],
            "output" => [
                "formats" => [
                    [
                        "type" => "svf",
                        "views" => [
                            "2d",
//                            "3d"
                        ]
                    ]
                ]
            ]
        ];

        $res = $this->client->request('POST', $this->url . '/modelderivative/v2/designdata/job',
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
    public function progress($objectId)
    {

        $res = $this->client->request('GET', $this->url . "/modelderivative/v2/designdata/" . base64_encode($objectId) . "/manifest",
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