# yii2-swagger
Yii2 Swagger 扩展       

## 安装
```
composer require huijiewei/yii2-swagger
```

## 用法

##### Controller 里面集成 Action:
```php
public function actions()
{
    return [
        'ui' => [
            'class' => 'huijiewei\swagger\actions\SwaggerUiAction',
            'apiUrl' => \yii\helpers\Url::to(['/site/api'], true),
        ],
        'api' => [
            'class' => 'huijiewei\swagger\actions\SwaggerApiAction',
            'scanDir' => '扫描的目录，可以是数组，支持 yii 的 alias'，
        ],
    ];
}
```

##### Module 里面集成 Controller:
```php
public function init()
{
    parent::init();

    $this->controllerMap = [
        'swagger' => [
            'class' => 'huijiewei\swagger\SwaggerController',
            'apiOptions' => [
                'scanDir' => '扫描的目录，可以是数组，支持 yii 的 alias',
                'defines' => [ // 可以定义一些常量，具体查阅 swagger-php 文档
                    'API_HOST' => 'API_HOST',
                    'API_BASE_PATH' => 'BASE_PATH'
                ]
            ],
            'uiOptions' => [
                'apiUrlRoute' => 'swagger/api'
            ]
        ],
    ];
}
```

### 更多文档
查阅 [Swagger PHP 文档](http://zircote.com/swagger-php/).

查阅 [Swagger UI 文档](https://github.com/swagger-api/swagger-ui).

感谢 `swagger-php` `swagger-ui` 
