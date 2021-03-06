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
    <p> <?= \Yii::$app->edbo->hostEDBOGuides ?>  </p>
    <p> <?= \Yii::$app->edbo->hostEDBOPerson ?>  </p>

    <?php
        //use yii\bootstrap\Tabs;
    use kartik\tabs\TabsX;;
            echo TabsX::widget([
            'items' => [
                [
                    'label' => 'Reload reference data of EDBO',
                    //'active' => true,
                    'content' => $this->render('../tabs/index', [
                        'model' => NULL,
                    ]),
                    //'url'=>[\yii\helpers\Url::to(['/EDBOtest/tabs/tabs-data'])],
                    //'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/EDBOadmin/tabs/tabs-data'])],
                    //'linkOptions' => ['data-url' => 'edbotest/tabs/tabsData'],
                    
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
                             'encode' => false,
                             'content' => 'DropdownA, Anim pariatur cliche...',
                         ],
                         [
                             'label' => 'DropdownB',
                             'encode' => false,
                             'content' => 'DropdownB, Anim pariatur cliche...',
                         ],
                    ],
                ],
            ],
        ]);
    ?>

</div>
