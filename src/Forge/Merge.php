<?php
namespace Forge;

class Merge
{
    //模型合并
    public static function Model($input,$outobjectname)
    {
        $data = [
            "input" => $input,
            "output" => [
                "bucketKey" => "lvp",
                "objectName" => $outobjectname
            ]
        ];

        return Api::PostJson($data, 'job/v1/author-merger', Auth::Token());
    }


    //合并进度
    public static function progress($urn)
    {
        return Api::Get("job/v1/author-merger/" . $urn, Auth::Token());
    }
}