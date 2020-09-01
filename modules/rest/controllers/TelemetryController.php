<?php


namespace app\modules\rest\controllers;

use app\models\Telemetries;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class TelemetryController extends  Controller
{
    public $freeAccess = true;
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
    // public function beforeAction() { сгенерировать accessToken}
    public function actionIndex(){

        $name = \Yii::$app->request->getBodyParam('name');
        $query = Telemetries::find();

        if ($name !== null){
            $query = Telemetries::find()->andWhere(['name' => $name]);
        }
        $query->asArray();
        $dataProvider = new ActiveDataProvider([
            'query' => $query, //добавить фильтры

        ]);
        $array = $dataProvider->getModels();
        for ($i=0;$i<count($array);$i++){
              $array[$i]['value'] = json_decode($array[$i]['value']);
        }
        $dataProvider2 = new ArrayDataProvider([
            'allModels' => $array,

        ]);
        return $dataProvider2; //unserialize($array[0]['value']);

    }

    public function actionCreate()
    {
        $name = \Yii::$app->request->getBodyParam('name');
        $value = json_encode(\Yii::$app->request->getBodyParam('value'));
        $telemetry = new Telemetries();
        $telemetry->name = $name;
        $telemetry->value = $value;
        $telemetry->time = date("Y-m-d H:i:s");
        if ( $telemetry->validate()){
            $telemetry->save();
        }
        return $telemetry;
    }
}