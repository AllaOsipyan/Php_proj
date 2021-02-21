<?php
namespace app\modules\socket\controllers;

class SocketController extends \yii\web\Controller
{
    public function actionIndex(){
        if (\Yii::$app->user->can('createTelemetry')) {
            return $this->render('index');
        }
        return \Yii::$app->view->renderFile('@app/views/site/error.php',
            [
                'name' => 'Forbidden',
                'message' => 'You should have admin permissions to see this page.'
            ]);
    }
}