<?php
use yii\widgets\Pjax;
use kartik\grid\GridView;
?>

<?php
//return;
	if (is_null($model->EDBOTableProvider)) {
		echo "Not found data this->id_directory = " . $model->id_directory;
		return;
	}
	//echo "model->show_table = " . $model->show_table;
	if (!$model->show_table)
		return;
 ?>
   
    <?= GridView::widget([
        'dataProvider' => $model->EDBOTableProvider,
        'caption' => $model->tableName . ' (' .$model->tableDescription .')',
        //'filterModel' => $searchModel,
        'columns' =>  yii\helpers\ArrayHelper::merge([
            ['class' => 'yii\grid\SerialColumn'],
          
        ], $model->getEDBOTableColumns()),

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
    


