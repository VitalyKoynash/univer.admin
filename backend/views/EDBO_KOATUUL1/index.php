<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EDBO_KOATUUL1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Edbo  Koatuul1s');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edbo--koatuul1-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Edbo  Koatuul1',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            // 'KOATUUName',
            // 'KOATUUFullName',
            // 'KOATUUDateBegin',
            // 'KOATUUDateEnd',
            // 'Id_Language',
            // 'KOATUUCodeL1',
            // 'KOATUUCodeL2',
            // 'KOATUUCodeL3',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
