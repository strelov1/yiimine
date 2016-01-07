<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="YiimineApp">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php
    $this->registerJsFile('/js/angular.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('/js/angular-drag-and-drop-lists.min.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('/js/controllers/SiteIndexCtrl.js', ['position' => \yii\web\View::POS_HEAD]);
    $this->registerJsFile('/js/main.js', ['position' => \yii\web\View::POS_END]);
    $this->registerJsFile('/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js', ['position' => \yii\web\View::POS_END]);
    $this->registerJsFile('/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5', ['position' => \yii\web\View::POS_END]);
    $this->registerJsFile('/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5', ['position' => \yii\web\View::POS_END]);
    $this->registerJsFile('/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6', ['position' => \yii\web\View::POS_END]);
    $this->registerJsFile('/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7', ['position' => \yii\web\View::POS_END]);
    $this->registerCssFile('/js/fancybox/source/jquery.fancybox.css?v=2.1.5');
    $this->registerCssFile('/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5');
    $this->registerCssFile('/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7');
    ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => $this->params['appSettings']['app_name'],
        'brandUrl' => Yii::$app->homeUrl,
        'renderInnerContainer' => false,
        'options' => [
            'class' => 'navbar navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => [
            ['label' => '<i class="fa fa-list-alt text-success"></i> ' . \Yii::t('app', 'Projects'), 'url' => ['/project/index']],
            !Yii::$app->user->isGuest ?
                ['label' => '<i class="fa fa-sticky-note-o text-warning"></i> ' . \Yii::t('app', 'Notes'), 'url' => ['/note/index']] :
                '',
            !Yii::$app->user->isGuest ?
                ['label' => '<i class="fa fa-plus"></i> ' . \Yii::t('app', 'New Issue'), 'url' => ['/issue/create-empty']] :
                '',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => \Yii::t('app', 'Login'), 'url' => ['/user/login']],
                ['label' => \Yii::t('app', 'Signup'), 'url' => ['/user/signup']]
            ],
        ]);
    } else {
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                \Yii::$app->user->can('adminDashboard') ?
                    ['label' => '<i class="fa fa-users text-success"></i> '.\Yii::t('app', 'Users'), 'url' => ['/admin/user/index']] :
                    '',
                \Yii::$app->user->can('adminDashboard') ?
                    ['label' => '<i class="fa fa-cogs text-danger"></i> '.\Yii::t('app', 'Administration'), 'url' => ['/admin/application']] :
                    '',
                '<li id="youSignAs">'.\Yii::t('app', 'Logged in as').' '.Html::a(Yii::$app->user->identity->username, ['/user/profile']) . '</li>',
                ['label' => '<i class="fa fa-sign-out"></i>' . \Yii::t('app', 'Logout'), 'url' => ['/user/logout'], 'linkOptions' => ['data-method' => 'post']],
            ],
        ]);
    }

    NavBar::end();
    ?>
    <br/><br/><br/>
    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php
        echo $this->render('@app/views/common/_flashMessage');
        echo $content;
        ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; YiiMine 2014-<?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
