<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->title = Yii::$app->name; 
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'DSEA EDBO admin panel',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Admin panel ',
                    'url' => ['/admin'],
                    'linkOptions' => ['data-method' => 'post']];
                    
                $menuItems[] = [
                    //'label' => 'Logout (' . Yii::$app->user->identity->username .')',
                /*
                'label' => 'Logout (' . Yii::$app->user->identity->username . ' ['. Yii::$app->user->identity->getEdbouser('email') .']'.')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']];
                */
                'options'=>['rel'=>'tooltip', 'title'=>'EDBO user: '.Yii::$app->user->identity->getEdbouser('email') ],
                'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']];
            }
            
            //~~~~~~~~~~~~~~~

            use mdm\admin\components\MenuHelper;
            $mi = MenuHelper::getAssignedMenu(Yii::$app->user->id, 1);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => array_merge($mi,  $menuItems),
            ]);
            //~~~~~~~~~~~~~~~
            echo '<form class="pull-left">';
            echo app\modules\EDBOadmin\widgets\EDBOStatusWidget::widget(); //['interval_check' => 30000]
            echo '</form>';

            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        
        <!--?php
            use mdm\admin\components\MenuHelper;
                        echo Nav::widget([
                'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id)
            ]);
        ?-->
        

        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
