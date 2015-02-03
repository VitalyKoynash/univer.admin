<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EdboUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Edbousers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edbouser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Edbouser',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'password',
            'email:email',
            'sessionguid',
            //'sessionguid_updated_at',
            [
                'attribute' => 'sessionguid_updated_at',
                'format' => 'html',
                'label' => Yii::t('app', 'Sessionguid_updated_at'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->sessionguid_updated_at, "php:d-m-Y H:i:s");
                    //$date = new DateTime($model->created_at, new DateTimeZone("UTC"));
                    //return $date->format('Y-m-d H:i:s');
                }
            ],
            'status',
            //'created_at',
            //'updated_at',
            [
                'attribute' => 'created_at',
                'format' => 'html',
                'label' => Yii::t('app', 'Created_at'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, "php:d-m-Y H:i:s");
                    //$date = new DateTime($model->created_at, new DateTimeZone("UTC"));
                    //return $date->format('Y-m-d H:i:s');
                }
            ],
            //'updated_at',
             [
                'attribute' => 'updated_at',
                'format' => 'html',
                'label' => Yii::t('app', 'Updated_at'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at, "php:d-m-Y H:i:s");
                    //$date = new DateTime($model->created_at, new DateTimeZone("UTC"));
                    //return $date->format('Y-m-d H:i:s');
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
