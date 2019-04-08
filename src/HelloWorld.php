<?php
/**
 * Created by PhpStorm.
 * User: HZY
 * Date: 2019/4/8
 * Time: 14:43
 */

class HelloWorld
{
    // 作者
    protected $author;

    /**
     * HelloWorld constructor.
     * @param string $author
     */
    public function __construct($author = 'scort')
    {
        $this->author = $author;
    }

    /**
     * 执行方法
     * @return string
     */
    public function info()
    {
        $info = "Hello World ! \n";
        $info .= "\t--Power By ";
        $info .= $this->author . "\n";
        return $info;
    }
}