<?php

use yii\helpers\Html;
use kartik\grid\GridView;

?>
<div class="edbokoatuul1-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
