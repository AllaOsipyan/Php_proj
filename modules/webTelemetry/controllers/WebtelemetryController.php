<?php


namespace app\modules\webTelemetry\controllers;


use app\models\Telemetries;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class WebtelemetryController extends Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->user->can('browseTelemetry')) {
            // create post

            $query = Telemetries::find();

            $query->asArray();
            $dataProvider = new ActiveDataProvider([
                'query' => $query, //добавить фильтры

            ]);
            return $this->render('index', [
                'dataProvider' =>$dataProvider
            ]);
        }
        return \Yii::$app->view->renderFile('@app/views/site/error.php',
            [
                'name' => 'Forbidden',
                'message' => 'You should be authorized user to see this page.'
            ]);
    }

    public function actionFind(){

    }
}