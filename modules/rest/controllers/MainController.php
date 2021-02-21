<?php


namespace app\modules\rest\controllers;


use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        return $this->render('/telemetry/index');
    }

}