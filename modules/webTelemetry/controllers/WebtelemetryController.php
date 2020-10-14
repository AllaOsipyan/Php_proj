<?php


namespace app\modules\webTelemetry\controllers;


use app\models\Telemetries;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class WebtelemetryController extends Controller
{
    public function actionIndex()
    {
        $query = Telemetries::find();

        /*if ($name !== null){
            $query = Telemetries::find()->andWhere(['name' => $name]);
        }*/
        //$query->addSelect('JSON_QUERY(value)');
        $query->asArray();
        $dataProvider = new ActiveDataProvider([
            'query' => $query, //добавить фильтры

        ]);


        return $this->render('index', [
            'dataProvider' =>$dataProvider
        ]);
    }

    public function actionFind(){

    }
}