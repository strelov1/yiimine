<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = \Yii::t('app', 'Projects') . ' - ' . $this->params['appSettings']['app_name'];
?>
<div class="row">
    <div class="col-sm-9">
        <h1><?= \Yii::t('app', 'Projects'); ?></h1>
    </div>
    <div class="col-sm-3 text-right">
        <?php
        if (!Yii::$app->user->isGuest) {
            echo Html::a('<i class="fa fa-plus"></i> '.\Yii::t('app', 'New Project'), ['/project/create'], ['class' => 'btn btn-primary']);
        }
        ?>
    </div>
</div>

<?php if (!Yii::$app->user->isGuest): ?>
    <div class="btn-group pull-right m-b-10" role="group">
        <a href="<?= Url::toRoute(['index']); ?>" class="btn btn-default <?= (empty($status)) ? 'active' : ''; ?>">
            <?= \Yii::t('app', 'All'); ?>
        </a>
        <a href="<?= Url::toRoute(['index', 'status' => 'public']); ?>" class="btn btn-default <?= ($status =='public') ? 'active' : ''; ?>">
            <?= \Yii::t('app', 'Public'); ?>
        </a>
        <a href="<?= Url::toRoute(['index', 'status' => 'private']); ?>" class="btn btn-default <?= ($status =='private') ? 'active' : ''; ?>">
            <?= \Yii::t('app', 'Private'); ?>
        </a>
    </div>
    <div class="clearfix"></div>
<?php endif; ?>

<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => '{items} {pager}',
]);