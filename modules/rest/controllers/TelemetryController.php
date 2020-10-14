<?php


namespace app\modules\rest\controllers;

use yii\web\Response;
use app\models\Telemetries;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\filters\auth\HttpBearerAuth;
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
    public function behaviors() {

        $behaviors = parent::behaviors();

         $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }
    // public function beforeAction() { сгенерировать accessToken}
    public function actionIndex($name1){

        $name = \Yii::$app->request->getBodyParam('name');
        $query = Telemetries::find();

        if ($name1 !== ""){
            $query = Telemetries::find()->andWhere(['name' => $name1]);
        }
        //$query->addSelect('JSON_QUERY(value)');
        $query->asArray();
        $dataProvider = new ActiveDataProvider([
            'query' => $query, //добавить фильтры

        ]);
        $array = $dataProvider->getModels();
        for ($i=0;$i<count($array);$i++){
              $array[$i]['value'] = json_decode($array[$i]['value']);
        }
        return  $array; //unserialize($array[0]['value']);

    }

    public function actionCreate()
    {
        $telemetry = new Telemetries();
        $data = \Yii::$app->request->getBodyParams();
        if (array_key_exists('name', $data) && array_key_exists('value', $data)){
            $telemetry->name = $data['name'];
            $telemetry->value = json_encode($data['value']);
        }
        else {
            $telemetry->name = array_keys($data)[0];
            $telemetry->value = json_encode($data[$telemetry->name]);
        }
        $telemetry->time = date("Y-m-d H:i:s");

        if ( $telemetry->validate()){
            $telemetry->save();
        }
        return $telemetry;
    }
}