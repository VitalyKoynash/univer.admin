<?php
use yii\helpers\Html;
?>
<div class="form-group field-directoryfromedbo-id_directory">
<?=Html::dropDownList(
    'test', //name
    '0', //select
    ['' => 'Select Filter...', '1' => 'Exchanging Now', '2' => 'Last Exchanged', '3' => 'Last Offered', 
    '4' => 'Last Discounted', '5' => 'Last Recieved', '6' => 'View All'],
    ['class'=>'form-control']
    )

  ?>

  </div>
    


