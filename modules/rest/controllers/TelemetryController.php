<?php


namespace app\modules\rest\controllers;

use app\models\User;
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
    public function actionIndex($name1)
    {
        if (\Yii::$app->user->can("browseTelemetry")){
            $query = Telemetries::find();

            if ($name1 !== "") {
                $query = Telemetries::find()->andWhere(['name' => $name1]);
            }
            $query->asArray();
            $dataProvider = new ActiveDataProvider([
                'query' => $query,

            ]);
            $array = $dataProvider->getModels();
            for ($i = 0; $i < count($array); $i++) {
                $array[$i]['value'] = json_decode($array[$i]['value']);
            }
            return $array;
        }
        return \Yii::$app->view->renderFile('@app/views/site/error.php',
            [
                'name' => 'Forbidden',
                'message' => 'You should have admin permissions to see this page.'
            ]);
    }

    public function actionCreate()
    {
        if(\Yii::$app->user->can("createTelemetry")) {
            $telemetry = new Telemetries();
            $data = \Yii::$app->request->getBodyParams();
            if (array_key_exists('name', $data) && array_key_exists('value', $data)) {
                $telemetry->name = $data['name'];
                $telemetry->value = json_encode($data['value']);
            } else {
                $telemetry->name = array_keys($data)[0];
                $telemetry->value = json_encode($data[$telemetry->name]);
            }
            $telemetry->time = date("Y-m-d H:i:s");

            if ($telemetry->validate()) {
                $telemetry->save();
            }
            return $telemetry;
        }
        return null;
    }
}