<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 16:31
 */

namespace huijiewei\swagger\actions;

use yii\base\Action;
use yii\caching\CacheInterface;
use yii\di\Instance;
use yii\helpers\StringHelper;
use yii\web\Response;

class SwaggerApiAction extends Action
{
    public $scanDir;
    public $scanOptions = [];

    public $cache = 'cache';

    public $enableCache = false;

    public $cacheKey = 'bp-api-swagger-cache';

    public $defines = [];

    public function init()
    {
        $this->cache = Instance::ensure($this->cache, CacheInterface::class);
    }

    public function run($clearCache = false)
    {
        if ($clearCache !== false) {
            $this->cache->delete($this->cacheKey);

            return 'Swagger API 文档缓存清理成功';
        }


        foreach ($this->defines as $define => $value) {
            defined($define) || define($define, $value);
        }

        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if ($this->enableCache) {
            $swagger = $this->cache->get($this->cacheKey);

            if ($swagger !== false) {
                return $swagger;
            }
        }

        $swagger = $this->getSwagger();

        if ($this->enableCache) {
            $this->cache->set($this->cacheKey, $swagger);
        }

        return $swagger;
    }

    protected function getSwagger()
    {
        $scanDir = $this->scanDir;

        if (StringHelper::startsWith($scanDir, '@')) {
            $scanDir = \Yii::getAlias($scanDir);
        }

        return \Swagger\scan($scanDir, $this->scanOptions);
    }
}
