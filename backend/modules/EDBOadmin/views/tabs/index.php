<?php
use yii\widgets\Pjax;
use app\modules\EDBOadmin\widgets\UpdateEDBOTablesWidget;
use nirvana\showloading\ShowLoadingAsset;
ShowLoadingAsset::register($this);
?>

<?php //Pjax::begin(['timeout'=> 5*60000, 'linkSelector' => 'a[data-pjax]', 'enablePushState' => false]);  ?>

<?php //Pjax::end(); ?>

<?= UpdateEDBOTablesWidget::widget(['table' => 'KOATOUUL1']); ?>
<?= UpdateEDBOTablesWidget::widget(['table' => 'KOATOUUL2']); ?>


