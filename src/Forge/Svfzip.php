<?php
namespace Forge;


class Svfzip
{
    private static $url = "http://192.168.1.214:8000/";


    //转化成.svfzip
    public static function iCloud($urn, $filename)
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
        return Api::PostJson($data, 'modelderivative/v2/designdata/job', Auth::Token());
    }

    //模型转化成.svfzip
    public static function Model($urn, $filename)
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
                        "features" => ["ExcludeTexture","ExportGrids","ExportRooms","GenerateModelsDb","UseViewOverrideGraphic"],
                        "views" => [

                        ]
                    ]
                ]
            ]
        ];
        return Api::PostJson($data, 'modelderivative/v2/designdata/job', Auth::Token());
    }

    //图纸转化成.svfzip
    public static function Draw($urn, $filename)
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

        return Api::PostJson($data, 'modelderivative/v2/designdata/job', Auth::Token());

    }

    //转化进度
    public static function progress($urn)
    {

        return Api::Get("modelderivative/v2/designdata/" . base64_encode($urn) . "/manifest", Auth::Token());

    }

}