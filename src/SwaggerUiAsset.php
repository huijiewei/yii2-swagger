<?php
/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2017/7/6
 * Time: 下午5:04
 */

namespace huijiewei\swagger;

use yii\web\AssetBundle;
use yii\web\View;

class SwaggerUiAsset extends AssetBundle
{
    public $sourcePath = '@npm/swagger-ui-dist';

    public $js = [
        'swagger-ui-bundle.js',
        'swagger-ui-standalone-preset.js',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];

    public $css = [
        'swagger-ui.css',
    ];
}
