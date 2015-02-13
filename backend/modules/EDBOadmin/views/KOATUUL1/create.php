<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EDBOKOATUUL1 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Edbokoatuul1',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Edbokoatuul1s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edbokoatuul1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
