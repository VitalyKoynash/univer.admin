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
    <blockquote><?php $res=Yii::$app->edbo->EDBOGuides->Login('koinash.vitalii@edbo.gov.ua','iowv8ermnl'); print_r($res) ?></blockquote>
    <blockquote><?php $res=Yii::$app->edbo->EDBOGuides->LanguagesGet('5ac5c635-023f-4fa5-bc8f-b87a397448fc'); print_r($res) ?></blockquote>



</div>
