<?php
use yii\widgets\Pjax;

use app\modules\EDBOadmin\widgets\UpdateEDBOTablesWidget;

use nirvana\showloading\ShowLoadingAsset;
ShowLoadingAsset::register($this); //http://nix-tips.ru/yii2-indikator-zagruzki-showloading.html http://www.yiiframework.com/extension/yii2-showloading
//sleep(3);
?>

<?php Pjax::begin(['timeout'=> 5*600000, 'linkSelector' => 'a[data-pjax]', 'enablePushState' => false]);  ?>
<?= UpdateEDBOTablesWidget::widget(['table' => $table]); ?>
<?php Pjax::end(); ?>


