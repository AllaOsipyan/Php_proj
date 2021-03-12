<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\modules\user_management\models\UserForm */
$form = ActiveForm::begin(['action'=>['showusers','id'=>$model->status], 'method'=>"post"]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'login',
            'role',
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ($model['status']!= 'banned')?['checked'=>"checked"]:[];
                }
            ],
        ],
    ]);

?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>