<?php


namespace app\assets;


use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{
    public $publicOptions = ['forceCopy' =>true];
    public $sourcePath = '@app/assets/js';
    public $baseUrl = '@web';

    public function init()
    {
        parent::init();
        $this->js[] = YII_ENV === 'dev' ? 'app.js' : 'app.min.js';

    }
}