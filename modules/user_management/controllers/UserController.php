<?php

namespace app\modules\user_management\controllers;

use app\models\User;
use app\modules\user_management\models\RegistrationForm;
use app\modules\user_management\models\UserForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Console;
use yii\web\Controller;

class UserController extends Controller
{
    function actionIndex(){
        if (\Yii::$app->user->can('editUser')) {
            return $this->render('index');}
        return \Yii::$app->view->renderFile('@app/views/site/error.php',
            [
                'name' => 'Forbidden',
                'message' => 'You should have admin permissions to see this page.'
            ]);
    }

    function  actionRegister(){
        if (\Yii::$app->user->can('createUser')) {
            $model = new RegistrationForm();
            if ($model->load(Yii::$app->request->post()) && $model->register()) {
                $model->createUser();
                return $this->goHome();
            }
            $model->login = '';
            $model->password = '';
            $model->isAdmin = false;
            return $this->render('registration', [
                'model' => $model,
            ]);
        }
        return \Yii::$app->view->renderFile('@app/views/site/error.php',
            [
                'name' => 'Forbidden',
                'message' => 'You should have admin permissions to see this page.'
            ]);
    }

    function actionShowusers() {
        if (\Yii::$app->user->can('editUser')) {
            $model = new UserForm();


            $selection = (array)Yii::$app->request->post('selection');
            if(!empty($selection)) {

                User::updateAll(['status' => 'banned']);
                foreach ($selection as $id) {
                    $user = User::findOne((int)$id);
                    $user->setStatus($user, $user->role, 'active');
                }
                $bannedUsers = User::Find()->where(['status' => 'banned'])->all();
                foreach ($bannedUsers as $el) {
                    $el->setStatus($el, 'bannedUser', 'banned');
                }
            }

            $query = User::Find();
            $query->asArray();
            $dataProvider = new ActiveDataProvider([
                'query' => $query,

            ]);
            $model->validateActive();
            return $this->render('users', [
                'dataProvider' =>$dataProvider,
                'model' => $model,
            ]);
        }
        return \Yii::$app->view->renderFile('@app/views/site/error.php',
            [
                'name' => 'Forbidden',
                'message' => 'You should have admin permissions to see this page.'
            ]);
    }


}