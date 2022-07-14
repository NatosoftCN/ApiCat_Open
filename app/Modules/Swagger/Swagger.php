<?php

namespace App\Modules\Swagger;

use Illuminate\Support\Facades\File;

/**
 * Swagger 数据文件的解析和生成
 * https://github.com/OAI/OpenAPI-Specification/blob/main/versions/2.0.md
 */
class Swagger
{
    /**
     * 文档内容
     *
     * @var string
     */
    public $content;

    /**
     * 解析器对象
     *
     * @var Parser
     */
    protected $parser;

    /**
     * 生成器对象
     *
     * @var Maker
     */
    protected $writer;

    /**
     * __construct
     *
     * @param string $content 文档内容
     * @return void
     */
    public function __construct($content = null)
    {
        if ($content ) {
            $this->content = $content;
            $this->wantParse();
        } else {
            $this->wantWrite();
        }
    }

    /**
     * 获取根据标签分组的path数组
     *
     * @return array
     */
    public function getPathGroup()
    {
        return $this->parser->getPathGroup();
    }

    /**
     * 解析API内容
     *
     * @param array $api API相关信息
     * @return array
     */
    public function parse($api)
    {
        $result = [
            'protocol' => $this->parser->getProtocol(),
            'host' => $this->parser->getHost(),
            'base_path' => $this->parser->getBasePath(),
            'path' => $api['path'],
            'method' => $api['method'],
            'summary' => isset($api['summary']) ? $api['summary'] : '',
            'description' => isset($api['description']) ? $api['description'] : '',
            'produces' => isset($api['produces']) ? $api['produces'] : [],
            'consumes' => isset($api['consumes']) ? $api['consumes'] : [],
            // 'request'
        ];
    }

    protected function requestParams()
    {}

    /**
     * 解析文档内容
     *
     * @return void
     */
    protected function wantParse()
    {
        $this->parser = new Parser($this->content);
    }

    /**
     * 生成文档内容
     *
     * @return void
     */
    protected function wantWrite()
    {
        $this->writer = new Maker();
    }
}