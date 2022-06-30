<?php

namespace App\Modules\Swagger;

use Illuminate\Support\Facades\File;

/**
 * Swagger 数据文件的解析和生成
 * https://github.com/OAI/OpenAPI-Specification/blob/main/versions/2.0.md
 */
class Swagger
{
    use Parser;
    
    /**
     * 文档内容
     *
     * @var string
     */
    public $content;

    /**
     * Swagger version
     *
     * @var string
     */
    public $swagger = '2.0';

    /**
     * API 元数据，用于描述 API 的一些基本信息
     *
     * @var array
     */
    public $info = [
        // API 文档名称
        'title' => '',
        // API 版本
        'version' => '1.0.0',
        // API 文档描述
        'description' => ''
    ];

    /**
     * API 地址的域名或IP
     * host 中不能包含 API 的路径Path，可以有端口号
     * 例: 127.0.0.1:8000 or localhost:8000
     *
     * @var string
     */
    public $host = '';

    /**
     * 基础路径
     *
     * @var string
     */
    public $basePath = '/';

    /**
     * API 传输协议: http, https, ws, wss
     *
     * @var array
     */
    public $schemes = ['http'];

    /**
     * API 路径
     *
     * @var array
     */
    public $paths = [];

    /**
     * 定义请求和返回的数据类型
     *
     * @var array
     */
    public $definitions = [];

    /**
     * 跨 API 使用的参数
     *
     * @var array
     */
    public $parameters = [];

    /**
     * 跨 API 使用的返回内容
     *
     * @var array
     */
    public $responses = [];

    /**
     * 定义的安全方案
     *
     * @var array
     */
    public $securityDefinitions = [];

    /**
     * 整个 API 支持哪些安全方案
     *
     * @var array
     */
    public $security = [];

    /**
     * API 的标签分类
     *
     * @var array
     */
    public $tags = [];
    
    /**
     * 额外的文档描述
     *
     * @var array
     */
    public $externalDocs = [];

    /**
     * 读取文档内容
     *
     * @param string $filePath 文档路径
     * @return boolean
     */
    public function readFile($filePath)
    {
        if (!File::exists($filePath)) {
            return false;
        }

        if ($this->content = file_get_contents($filePath)) {
            return true;
        }
        return false;
    }
}