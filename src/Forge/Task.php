<?php

namespace Forge;


class Task
{
    private $url = null;
    private $client = null;

    public function __construct($url = "")
    {
        if ($url === "") {
            throw new \Exception("URL不能为空", 500);
        }
        $this->client = new \GuzzleHttp\Client();
        $this->url = $url;
    }


    public function Summit($origin, $type, $objectKey, $path, $foreignKey = null, $project_id = null, $objectKeyArray = [], $exportRooms = null, $exportGrids = null, $renderColor = null, $thumbnail = null)
    {
        $data['origin'] = $origin;
        $data['type'] = $type;
        $data['objectKey'] = $objectKey;
        $data['objectKeyArray'] = $objectKeyArray;
        $data['foreignKey'] = $foreignKey;
        $data['path'] = $path;
        $data['project_id'] = $project_id;
        $data['exportRooms'] = $exportRooms;
        $data['exportGrids'] = $exportGrids;
        $data['renderColor'] = $renderColor;
        $data['thumbnail'] = $thumbnail;

        $res = $this->client->request('POST', $this->url . '/forgeapi/public/api/task',
            [
                'json' => $data,
                'headers' => [
                    "Content-Type" => "application/json",
                ]
            ]
        );

        $data = $res->getBody()->getContents();

        return json_decode($data);
    }

    public function Get($origin, $type, $objectKey)
    {
        $data['origin'] = $origin;
        $data['type'] = $type;
        $data['objectKey'] = $objectKey;
        $res = $this->client->request('POST', $this->url . '/forgeapi/public/api/svfpath',
            [
                'json' => $data,
                'headers' => [
                    "Content-Type" => "application/json",
                ]
            ]
        );

        $data = $res->getBody()->getContents();

        return json_decode($data);
    }

}