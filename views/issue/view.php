<?php
/**
 * @var $model app\models\Issue
 */
use app\components\enums\PriorityEnum;
use app\components\enums\StatusEnum;
use app\components\enums\TrackerEnum;
use app\models\Issue;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = \Yii::t('app', 'Issue').' #'.$model->id.' - '.$model->subject.' - '.$this->params['appSettings']['app_name'];

$editLink = '';
if ($model->creator_id == \Yii::$app->user->id || \Yii::$app->user->can('adminDashboard')) {
    $editLink = Html::a('<i class="fa fa-edit"></i>', ['/issue/update', 'id' => $model->id], ['class' => 'pull-right']);
}

/*$this->params['breadcrumbs'][] = ['label' => $this->params['appSettings']['app_name'], 'url' => ['/project/issues', 'id' => $model->project_id]];
$this->params['breadcrumbs'][] = $model->subject;*/

echo $this->render('/project/_topMenu', ['model' => $model->project]);
?>
<h1><?= '#'.$model->id .': '. Html::encode($model->subject).$editLink; ?></h1>
<i><?= \Yii::t('app', 'Added by').' <u>'.$model->author->getFullName().'</u> '.$model->created_date;?></i>

<div class="row">
    <div class="col-sm-3">
        <dl class="dl-horizontal">
            <dt><?= \Yii::t('app', 'Status'); ?></dt>
            <dd>
                <?php
                echo Editable::widget([
                    'model' => $model,
                    'attribute' => 'status_id',
                    'header' => \Yii::t('app', 'Status'),
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => StatusEnum::i()->getMap(),
                    'options' => ['class'=>'form-control'],
                    'displayValue' => StatusEnum::i()->getMap()[$model->status_id],
                ]);
                ?>
            </dd>
            <dt><?= \Yii::t('app', 'Priority'); ?></dt>
            <dd>
                <?php
                echo Editable::widget([
                    'model' => $model,
                    'attribute' => 'priority_id',
                    'header' => \Yii::t('app', 'Priority'),
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => PriorityEnum::i()->getMap(),
                    'options' => ['class'=>'form-control'],
                    'displayValue' => PriorityEnum::i()->getMap()[$model->priority_id],
                ]);
                ?>
            </dd>
            <dt><?= \Yii::t('app', 'Tracker'); ?></dt>
            <dd>
                <?php
                echo Editable::widget([
                    'model' => $model,
                    'attribute' => 'tracker_id',
                    'header' => \Yii::t('app', 'Priority'),
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => TrackerEnum::i()->getMap(),
                    'options' => ['class'=>'form-control'],
                    'displayValue' => TrackerEnum::i()->getMap()[$model->tracker_id],
                ]);
                ?>
            </dd>
        </dl>
    </div>
    <div class="col-sm-3">
        <dl class="dl-horizontal">
            <dt><?= \Yii::t('app', 'Assignee'); ?></dt>
            <dd>
                <?php
                echo Editable::widget([
                    'model' => $model,
                    'attribute' => 'assignee_id',
                    'header' => \Yii::t('app', 'Assignee'),
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => \app\models\Project::getAssigneeOptions($model->project_id),
                    'options' => ['class'=>'form-control', 'prompt' => ' - '],
                    'displayValue' => ($model->assignee ? $model->assignee->getFullName() : '<i>('.\Yii::t('app', 'not set').')</i>'),
                ]);
                ?>
            </dd>
            <dt><?= \Yii::t('app', '% Done'); ?></dt>
            <dd>
                <?php
                echo Editable::widget([
                    'model' => $model,
                    'attribute' => 'readiness_id',
                    'header' => \Yii::t('app', '% Done'),
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => Issue::getReadinessOptions(),
                    'options' => ['class'=>'form-control'],
                    'displayValue' => Issue::getReadinessOptions()[$model->readiness_id],
                ]);
                ?>
            </dd>
            <dt><?= \Yii::t('app', 'Deadline'); ?></dt>
            <dd>
                <?php
                echo Editable::widget([
                    'model'=>$model,
                    'attribute'=>'deadline',
                    'size'=>'md',
                    'inputType' => Editable::INPUT_DATE,
                    'displayValue' => $model->deadline,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                        ],
                    ],
                ]);
                ?>
            </dd>
        </dl>
    </div>
    <div class="col-sm-6">

    </div>
</div>
<hr/>
<div class="row">
    <?php if ($model->description): ?>
        <div class="col-sm-12">
            <strong><?= \Yii::t('app', 'Description'); ?></strong><br/>
            <?= \yii\helpers\HtmlPurifier::process($model->description); ?>
        </div>
    <?php endif; ?>
    <?php if ($model->checkLists): ?>
        <div class="col-sm-12" ng-controller="ChecklistCtrl" ng-init="init()">
            <strong><?= \Yii::t('app', 'Checklist'); ?></strong>
            <ul class="list-unstyled">
                <li ng-repeat="item in items" ng-cloak="">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" ng-model="item.status_id" ng-change="updateModel(item)">
                            <span class="done-{{item.status_id}}">{{item.item}}</span>
                        </label>
                    </div>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?php if($model->photos): ?>
    <div class="row">
        <div class="col-sm-12">
            <?php
            foreach ($model->photos as $photo) {
                echo Html::a(
                    Html::img($model->getMultiFileUrl() . 'thumb_'.$photo->file, ['class' => 'img-thumbnail m-r-10', 'style' => 'height: 100px;']),
                    $model->getMultiFileUrl().$photo->file, ['class' => 'fancybox', 'rel' => 'group']
                );
            }
            ?>
        </div>
    </div>
<?php endif; ?>
<hr/>
<div class="row">
    <div class="col-sm-12">
        <h2><?= Yii::t('app', 'Comments'); ?></h2>
        <?php
        if ($model->comments) {
            foreach ($model->comments as $i => $comment): ?>
                <div class="row">
                    <div class="col-sm-2 text-right">
                        <?php
                        echo '<strong>'.$comment->user->getFullName().'</strong><br/>';
                        echo $comment->created_date;
                        ?>
                    </div>
                    <div class="col-sm-9">
                        <?= nl2br(\yii\helpers\HtmlPurifier::process($comment->text)); ?>
                    </div>
                    <div class="col-sm-1">
                        <?php
                        if (\Yii::$app->user->can('adminDashboard')) {
                            echo Html::a('<i class="fa fa-times text-danger"></i>', ['/issue/delete-comment', 'id' => $comment->id], ['class' => 'confirmLink']);
                        }
                        ?>
                    </div>
                </div>
            <?php
                if (isset($model->comments[$i+1])) {
                    echo "<hr/>";
                }
            endforeach;
            echo "<hr/>";
        }
        echo $this->render('_commentForm', ['model' => new \app\models\IssueComment()]);
        ?>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-12">
        <h2><?= Yii::t('app', 'Logs'); ?></h2>
        <?php
        echo \app\components\widgets\LogsGridWidget::widget(['model' => \app\models\Log::MODEL_ISSUE, 'model_id' => $model->id]);
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".fancybox").fancybox({
            prevEffect	: 'none',
            nextEffect	: 'none',
            helpers	: {
                title	: {
                    type: 'outside'
                },
                thumbs	: {
                    width	: 50,
                    height	: 50
                }
            }
        });
    });

    function ChecklistCtrl($scope, $http) {
        $scope.items = <?= Json::encode($model->checkLists); ?>;

        $scope.show = function() {
            console.log($scope.items);
        }

        $scope.init = function() {
            angular.forEach($scope.items, function(obj, key) {
                if (obj.status_id == 1) {
                    obj.status_id = true;
                } else {
                    obj.status_id = false;
                }
            });
        }

        $scope.updateModel = function(item) {
            $.post('<?= Url::toRoute(['/checklist/toggle-status'])?>', {id: item.id});
        }
    }
</script>