<div class="EDBOtest-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
    <p><?=Yii::$app->edbo->info();?></p>
    <!--blockquote><?php $res=Yii::$app->edbo->EDBOGuides->Login(); print_r($res) ?></blockquote>
    <blockquote><?php $res=Yii::$app->edbo->EDBOGuides->LanguagesGet(); print_r($res) ?></blockquote>
    <blockquote><?php $res=Yii::$app->edbo->EDBOGuides->GetLastError(); print_r($res) ?></blockquote-->
    <?php foreach (Yii::$app->edbo->EDBOGuides->test() as $key => $test_item_func): ?>
        <blockquote> <?php echo $test_item_func(); ?> </blockquote>
    <?php endforeach; ?>


</div>
