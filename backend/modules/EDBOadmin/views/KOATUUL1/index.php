<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\KOATUUL1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Edbokoatuul1s');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edbokoatuul1-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!-- ?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Edbokoatuul1',
]), ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class'=>'kartik\grid\ExpandRowColumn',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_expand-row-details', ['model'=>$model]);
                },
                'headerOptions'=>['class'=>'kartik-sheet-style'] 
                //'disabled'=>true,
                //'detailUrl'=>Url::to(['/site/test-expand'])
            ],

            'id',
            'Id_KOATUU',
            'KOATUUCode',
            'Type',
            'Id_KOATUUName',
             'KOATUUName',
            // 'KOATUUFullName',
            // 'KOATUUDateBegin',
            // 'KOATUUDateEnd',
            // 'Id_Language',
             'KOATUUCodeL1',
            // 'KOATUUCodeL2',
            // 'KOATUUCodeL3',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop' => true],
        //'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],

    ]); ?>

</div>
