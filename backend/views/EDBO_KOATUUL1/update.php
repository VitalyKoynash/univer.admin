<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EDBO_KOATUUL1 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Edbo  Koatuul1',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Edbo  Koatuul1s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="edbo--koatuul1-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
