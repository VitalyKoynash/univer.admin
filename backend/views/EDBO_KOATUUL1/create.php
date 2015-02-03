<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EDBO_KOATUUL1 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Edbo  Koatuul1',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Edbo  Koatuul1s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edbo--koatuul1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
