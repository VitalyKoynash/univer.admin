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
    <?php
        use yii\bootstrap\Tabs;
            echo Tabs::widget([
            'items' => [
                [
                    'label' => 'One',
                    'content' => '1 - Anim pariatur cliche...',
                    'active' => true
                ],
                [
                    'label' => 'Two',
                    'content' => '2 - Anim pariatur cliche...',
                    'headerOptions' => [],
                    'options' => ['id' => 'myveryownID'],
                ],
                [
                    'label' => 'Dropdown',
                    'items' => [
                         [
                             'label' => 'DropdownA',
                             'content' => '3 - DropdownA, Anim pariatur cliche...',
                         ],
                         [
                             'label' => 'DropdownB',
                             'content' => '4 - DropdownB, Anim pariatur cliche...',
                         ],
                    ],
                ],
            ],
        ]);
    ?>
    <?php foreach (Yii::$app->edbo->EDBOGuides->test() as $key => $test_item_func): ?>
        <blockquote> <?php echo $test_item_func(); ?> </blockquote>
    <?php endforeach; ?>


</div>
