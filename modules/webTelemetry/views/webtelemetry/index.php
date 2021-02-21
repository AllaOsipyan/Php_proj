<?php

use yii\grid\GridView;
/* @var $dataProvider yii\data\ActiveDataProvider */
    if($dataProvider != null):
        echo GridView::widget([
            'dataProvider' => $dataProvider,
        ]);
    else: echo 'Forbidden';
    endif;
    ?>