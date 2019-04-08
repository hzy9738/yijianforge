<?php

namespace Forge;

class Compare
{
    private $forge = null;
    private $token = null;

    private function __construct()
    {
        $this->forge = new Api();
        $this->token = Auth::getInstance()->Token();
    }

    //模型对比
    public function Model($newobjectName, $oldobjectName, $outobjectname)
    {
        $data = [
            "input" => [
                "a" => [
                    "bucketKey" => "lvp",
                    "objectName" => $newobjectName,
                    "isSvfzip" => false
                ],
                "b" => [
                    "bucketKey" => "lvp",
                    "objectName" => $oldobjectName,
                    "isSvfzip" => false
                ]
            ],
            "output" => [
                "bucketKey" => "lvp",
                "objectName" => $outobjectname
            ]
        ];
        return $this->forge->PostJson($data, 'job/v1/author-differ', $this->token);
    }


    //转化进度
    public function progress($urn)
    {

        return $this->forge->Get("job/v1/author-differ/" . $urn, $this->token);

    }
}