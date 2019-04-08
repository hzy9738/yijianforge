<?php

namespace Forge;


class Svfzip
{

    private $forge = null;
    private $token = null;

    private function __construct()
    {
        $this->forge = new Api();
        $this->token = Auth::getInstance()->Token();
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
        return (new Api())->PostJson($data, 'modelderivative/v2/designdata/job', $this->token);
    }

    //模型转化成.svfzip
    public function Model($urn, $filename)
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
                        "features" => ["ExcludeTexture", "ExportGrids", "ExportRooms", "GenerateModelsDb", "UseViewOverrideGraphic"],
                        "views" => [

                        ]
                    ]
                ]
            ]
        ];
        return $this->forge($data, 'modelderivative/v2/designdata/job', $this->token);
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

        return (new Api())->PostJson($data, 'modelderivative/v2/designdata/job', $this->token);

    }

    //转化进度
    public function progress($urn)
    {

        return $this->forge->Get("modelderivative/v2/designdata/" . base64_encode($urn) . "/manifest", $this->token);

    }

}