<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Profile';
?>
<div class="profile">
    <h1><?= Html::encode($this->title) ?></h1>


        <div class="row">
            <div class="col-lg-5">
                <h3> Your login</h3>
                <h4><?= Html::tag('div', $model->login) ?></h4>
                <h3> Your role</h3>
                <h4><?= Html::tag('div', $model->role) ?></h4>
                <h3> Current status</h3>
                <h4><?= Html::tag('div', $model->status) ?></h4>
                <h3> Your access token</h3>
                <h4><?= Html::tag('div', $model->token) ?></h4>

            </div>
        </div>
    <div>
        <?php
        if (Yii::$app->user->can('createUser')) : ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::a('Create new user', ['/user_management/user/register'], ['class'=>'btn btn-primary']) ?>
                </div>
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::a('Show users', ['/user_management/user/showusers'], ['class'=>'btn btn-primary']) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>