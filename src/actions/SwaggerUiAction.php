<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 16:21
 */

namespace huijiewei\swagger\actions;

use yii\base\Action;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\Response;

class SwaggerUiAction extends Action
{
    public $title = 'Swagger-UI';

    public $apiUrl = '';

    /**
     * @var array The swagger-ui component configurations.
     * @see https://github.com/swagger-api/swagger-ui/blob/master/docs/usage/configuration.md
     */
    public $configurations = [];

    public $oauthConfiguration = [];

    protected $defaultConfigurations = [
        'dom_id' => '#swagger-ui',
        'deepLinking' => true,
        'presets' => [
            'SwaggerUIBundle.presets.apis',
            'SwaggerUIStandalonePreset',
        ],
        'plugins' => [
            'SwaggerUIBundle.plugins.DownloadUrl',
            'SwaggerUIBundle.plugins.Topbar',
        ],
        'layout' => 'StandaloneLayout',
        'validatorUrl' => null,
    ];

    public function run()
    {
        \Yii::$app->getResponse()->format = Response::FORMAT_HTML;

        $this->controller->layout = false;

        return $this->controller->getView()->renderFile(dirname(__DIR__) . '/views/index.php', [
            'configurations' => $this->prepareConfiguration(),
            'oauthConfiguration' => $this->oauthConfiguration,
            'title' => $this->title,
        ], $this->controller);
    }

    protected function prepareConfiguration()
    {
        $configurations = array_merge($this->defaultConfigurations, $this->configurations);

        if ($this->apiUrl) {
            $configurations[is_array($this->apiUrl) ? 'urls' : 'url'] = $this->apiUrl;
        }

        if (isset($configurations['plugins'])) {
            $configurations['plugins'] = array_map(
                [$this, 'convertJsExpression'],
                (array)$configurations['plugins']
            );
        }

        if (isset($configurations['presets'])) {
            $configurations['presets'] = array_map(
                [$this, 'convertJsExpression'],
                (array)$configurations['presets']
            );
        }

        return Json::encode($configurations);
    }

    protected function convertJsExpression($str)
    {
        return new JsExpression($str);
    }
}
