<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-tag"></i> <?= Yii::t('app', 'Tags'); ?></h3>
    </div>
    <div class="panel-body">
        <ul>
            <?php foreach($tags as $t): ?>
                <li><?= $t; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>