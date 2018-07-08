<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 17:07
 */

namespace huijiewei\swagger;

use huijiewei\swagger\actions\SwaggerApiAction;
use huijiewei\swagger\actions\SwaggerUiAction;
use yii\helpers\Url;
use yii\web\Controller;

class SwaggerController extends Controller
{
    public $apiOptions = [];
    public $uiOptions = [
        'apiUrlRoute'
    ];

    public function actions()
    {
        $apiUrlRoute = $this->uiOptions['apiUrlRoute'];

        unset($this->uiOptions['apiUrlRoute']);

        return [
            'api' => array_merge([
                'class' => SwaggerApiAction::class,
            ], $this->apiOptions),
            'ui' => array_merge([
                'class' => SwaggerUiAction::class,
                'apiUrl' => Url::toRoute([$apiUrlRoute], true)
            ], $this->uiOptions),
        ];
    }
}
