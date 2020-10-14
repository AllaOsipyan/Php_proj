<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\VueAsset;
use app\widgets\Alert;
use webvimark\modules\UserManagement\models\User;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
VueAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    use webvimark\modules\UserManagement\components\GhostMenu;
    use webvimark\modules\UserManagement\UserManagementModule;
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'encodeLabels'=>false,
        'activateParents'=>true,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => 'Backend routes',
                'items'=>UserManagementModule::menuItems()
            ],

            [
                'label' => 'Frontend routes',
                'items'=>[
                    ['label'=>'Login', 'url'=>['/user-management/auth/login'], 'visible'=>Yii::$app->user->isGuest],
                    ['label'=>'Logout', 'url'=>['/user-management/auth/logout'], 'visible'=>!Yii::$app->user->isGuest],
                    ['label'=>'Registration', 'url'=>['/user-management/auth/registration'], 'visible'=>Yii::$app->user->isGuest],
                    ['label'=>'Change own password', 'url'=>['/user-management/auth/change-own-password']],
                    ['label'=>'Password recovery', 'url'=>['/user-management/auth/password-recovery']],
                    ['label'=>'E-mail confirmation', 'url'=>['/user-management/auth/confirm-email']],
                    ['label'=>'restapi', 'url'=>['/api/restpresentation/index']],
                    ['label'=>'Telemetries', 'url'=>['/ui/webtelemetry/index']],
                    ['label'=>'web-socket', 'url'=>['/socket/sockettelemetry/index']],
                ],
            ],
        ],
    ]);
    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
