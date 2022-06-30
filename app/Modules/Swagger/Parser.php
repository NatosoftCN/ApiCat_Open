<?php

namespace App\Modules\Swagger;

/**
 * Swagger 数据文件内容解析
 * https://github.com/OAI/OpenAPI-Specification/blob/main/versions/2.0.md
 */
trait Parser
{
    /**
     * 请求参数列表
     *
     * @var array
     */
    protected $requestParams = [];

    /**
     * 返回参数列表
     *
     * @var array
     */
    protected $responseParams = [];

    /**
     * 内容初始化
     *
     * @param string $format 内容格式: json or yaml
     * @return boolean
     */
    public function init($format = 'json')
    {
        if ($format == 'json') {
            $content = json_decode($this->content, true);
        } else {
        }

        if (!isset($content['swagger'])) {
            return false;
        }
        $this->swagger = $content['swagger'];

        if (!isset($content['info'])) {
            return false;
        }
        $this->info = $content['info'];

        if (isset($content['host'])) {
            $this->host = $content['host'];
        }
        
        if (isset($content['basePath'])) {
            $this->basePath = $content['basePath'];
        }
        
        if (isset($content['schemes'])) {
            $this->schemes = $content['schemes'];
        }

        if (!isset($content['paths'])) {
            return false;
        }
        $this->paths = $content['paths'];

        if (isset($content['definitions'])) {
            $this->definitions = $content['definitions'];
        }
        
        if (isset($content['parameters'])) {
            $this->parameters = $content['parameters'];
        }
        
        if (isset($content['responses'])) {
            $this->responses = $content['responses'];
        }
        
        if (isset($content['securityDefinitions'])) {
            $this->securityDefinitions = $content['securityDefinitions'];
        }
        
        if (isset($content['security'])) {
            $this->security = $content['security'];
        }
        
        if (isset($content['tags'])) {
            $this->tags = $content['tags'];
        }
        
        if (isset($content['externalDocs'])) {
            $this->externalDocs = $content['externalDocs'];
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
     * 获取定义的参数
     *
     * @param string $name 定义的名称
     * @param boolean $isRequest 是否为请求参数
     * @return array
     */
    public function getParamDefinition($name, $isRequest = true)
    {
        if ($isRequest) {
            if (isset($this->requestParams[$name])) {
                return $this->requestParams[$name];
            }
        } else {
            if (isset($this->responseParams[$name])) {
                return $this->responseParams[$name];
            }
        }

        if (!isset($this->definitions[$name])) {
            return [];
        }
    }
}