<?php
/**
 * @var $project app\models\Project;
 */
use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = \Yii::t('app', 'Members Settings') . ' - ' . $this->params['appSettings']['app_name'];

echo $this->render('/project/_topMenu', ['model' => $project]);
echo $this->render('_secondMenu', ['project' => $project]);
?>
<div class="row">
    <div class="col-sm-9">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items} {pager}',
            'columns' => [
                [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->user->getFullName();
                    }
                ], [
                    'attribute' => 'roles',
                    'value' => function ($data) {
                        $roles = [];
                        if ($data->roles) {
                            foreach ($data->roles as $k => $v) {
                                $roles[] = User::getProjectRoleArray()[$v];
                            }
                        }
                        return implode(', ', $roles);
                    }
                ], [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}'
                ],
            ],
        ]);
        ?>
    </div>
    <div class="col-sm-3">
        <?= Html::beginForm(); ?>
        <h4><?= \Yii::t('app', 'Users'); ?></h4>
        <ul class="list-unstyled">
            <?php foreach ($users as $k => $user): ?>
                <li>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="<?= 'userId['.$user->id.']'; ?>"> <?= $user->getFullName(); ?>
                        </label>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <h4 class="m-t-10"><?= \Yii::t('app', 'Roles'); ?></h4>
        <ul class="list-unstyled">
            <?php foreach (User::getProjectRoleArray() as $k => $v): ?>
                <li>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="<?= 'roleId['.$k.']'; ?>"> <?= $v; ?>
                        </label>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?= Html::submitButton(\Yii::t('app', 'Add'), ['class' => 'btn btn-primary']); ?>
        <?= Html::endForm(); ?>
    </div>
</div>