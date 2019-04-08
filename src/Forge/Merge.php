<?php

namespace Forge;

class Merge
{
    private $forge = null;
    private $token = null;

    private function __construct()
    {
        $this->forge = new Api();
        $this->token = Auth::getInstance()->Token();
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

        return $this->forge->PostJson($data, 'job/v1/author-merger', $this->token);
    }


    //合并进度
    public function progress($urn)
    {
        return $this->forge->Get("job/v1/author-merger/" . $urn, $this->token);
    }
}