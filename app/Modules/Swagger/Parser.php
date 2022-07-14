<?php

namespace App\Modules\Swagger;

/**
 * Swagger 数据文件内容解析
 * https://github.com/OAI/OpenAPI-Specification/blob/main/versions/2.0.md
 */
class Parser
{
    /**
     * Swagger version
     *
     * @var string
     */
    public $swagger;

    /**
     * API 元数据，用于描述 API 的一些基本信息
     *
     * @var array
     */
    public $info;

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
     * 标签名称列表
     *
     * @var array
     */
    protected $tagNameList = [];

    /**
     * 路径组
     *
     * @var array
     */
    protected $pathGroup = [];

    /**
     * 没有tag的path在$pathGroup中默认的key值
     *
     * @var string
     */
    protected $noGroupNameKey = '_no_tag_path';

    /**
     * 参数定义列表
     *
     * @var array
     */
    protected $definitionParams = [];

    /**
     * 相应定义列表
     *
     * @var array
     */
    protected $definitionResponses = [];

    /**
     * 内容初始化
     *
     * @param string $content 内容
     * @param string $format 内容格式: json or yaml
     * @return void
     */
    public function __construct($content, $format = 'json')
    {
        if ($format == 'json') {
            $content = json_decode($content, true);
        } else {
        }

        $fields = [
            'swagger', 'info', 'host', 'basePath', 'schemes', 'paths', 'definitions',
            'parameters', 'responses', 'securityDefinitions', 'security', 'tags',
            'externalDocs'
        ];

        foreach ($fields as $field) {
            if (isset($content[$field])) {
                $this->$field = $content[$field];
            }
        }
    }

    /**
     * 内容校验
     *
     * @return boolean
     */
    public function validate()
    {
        if (!$this->swagger or !$this->info or !$this->paths) {
            return false;
        }
    }

    /**
     * 获取传输协议
     *
     * @return string
     */
    public function getProtocol()
    {
        $len = count($this->schemes);
        return $this->schemes[$len - 1];
    }

    /**
     * 是否为 HTTP or HTTPS 协议
     *
     * @return boolean
     */
    public function isHttp()
    {
        if (!$this->schemes) {
            return false;
        }

        if (in_array('http', $this->schemes) or in_array('https', $this->schemes)) {
            return true;
        }

        return false;
    }

    /**
     * 获取host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * 获取basePath
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * 获取定义的对象
     *
     * @param string $name 定义的名称
     * @param boolean $isRequest 是否为请求参数
     * @return array
     */
    public function getDefinition($name, $isParam = true)
    {
        if ($isParam) {
            if (isset($this->definitionParams[$name])) {
                return $this->definitionParams[$name];
            }
        } else {
            if (isset($this->definitionResponses[$name])) {
                return $this->definitionResponses[$name];
            }
        }

        if (!isset($this->definitions[$name])) {
            return [];
        }
    }

    /**
     * 获取标签名称列表
     *
     * @return array
     */
    public function getTagNameList()
    {
        if ($this->tagNameList) {
            return $this->tagNameList;
        }

        if (!$this->tags) {
            return [];
        }

        foreach ($this->tags as $v) {
            $this->tagNameList[] = $v['name'];
        }

        return $this->tagNameList;
    }

    /**
     * 获取根据标签分组的path数组
     *
     * @return array
     */
    public function getPathGroup()
    {
        if ($this->pathGroup) {
            return $this->pathGroup;
        }

        foreach ($this->paths as $path => $methods) {
            foreach ($methods as $method => $v) {
                $v['path'] = $path;
                $v['method'] = $method;

                $tags = isset($v['tags']) ? $v['tags'] : [];
                if (!$tags) {
                    if (!isset($this->pathGroup[$this->noGroupNameKey])) {
                        $this->pathGroup[$this->noGroupNameKey] = [];
                    }
                    $this->pathGroup[$this->noGroupNameKey][] = $v;
                } else {
                    foreach ($tags as $tag) {
                        if (!isset($this->pathGroup[$tag])) {
                            $this->pathGroup[$tag] = [];
                        }
                        $this->pathGroup[$tag][] = $v;
                    }
                }
            }
        }

        return $this->pathGroup;
    }
}