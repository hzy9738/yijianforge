<?php
namespace Forge;

class Compare
{
    //模型对比
    public static function Model($newobjectName, $oldobjectName,$outobjectname)
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
        return Api::PostJson($data, 'job/v1/author-differ', Auth::Token());
    }


    //转化进度
    public static function progress($urn)
    {

        return Api::Get("job/v1/author-differ/".$urn,Auth::Token());

    }
}