<?php
/* @var $this yii\web\View */
/* @var $model app\models\Issue */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use yii\jui\DatePicker;

if (!$model->isNewRecord) {
    $project = $model->project;
}

$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]);
?>

<?php
echo $form->field($model, 'tracker_id')->dropDownList(\app\components\enums\TrackerEnum::i()->getMap());
echo $form->field($model, 'subject');
?>
<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->field($model, 'description')->widget(Widget::classname(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'pastePlainText' => true,
                'buttonSource' => true,
                'plugins' => [
                    'clips',
                    'fullscreen'
                ],
            ]
        ]);
        ?>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="qwe" class="control-label"><?= \Yii::t('app', 'Checklist'); ?></label>
            <div class="checklistItems">
                <?php
                for($i=0; $i<count($checklistItems); $i++) {
                    echo $this->render('_listItem', [
                        'model' => $checklistItems[$i],
                        'index' => $i,
                    ]);
                }
                ?>
            </div>

            <a href="#" class="checklist-add pull-right"><i class="fa fa-plus-circle"></i> <?= \Yii::t('app', 'Add Checklist Item'); ?></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->field($model, 'milestone_id')->dropDownList(app\models\Milestone::getOptions($project->id), ['prompt' => ' ']);
        echo $form->field($model, 'status_id')->dropDownList(\app\components\enums\StatusEnum::i()->getMap());
        echo $form->field($model, 'priority_id')->dropDownList(\app\components\enums\PriorityEnum::i()->getMap());
        echo $form->field($model, 'assignee_id')->dropDownList(\app\models\Project::getAssigneeOptions($project->id), ['prompt' => ' ']);
        ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo $form->field($model, 'deadline')->widget(DatePicker::className(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
                'class' => 'form-control'
            ],
        ]);
        echo $form->field($model, 'readiness_id')->dropDownList(\app\models\Issue::getReadinessOptions());
        echo $form->field($model, 'image_array[]')->fileInput(['multiple' => ''])->hint(\Yii::t('app', 'Chose one or few files'));
        if (!empty($model->photos)) {
            echo $this->render('_imageGrid', ['model' => $model]);
        }
        ?>
    </div>
</div>

<?= Html::submitButton(($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Save')), ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>

<script>
    $(document).ready(function() {
        $('.checklist-add').click(function() {
            $.ajax({
                success: function(html) {
                    var i = $('.checklistItems .row').size();
                    $('.checklistItems').append(html);
                    $('#issuechecklist-'+i+'-item').focus();
                },
                type: 'get',
                url: '<?= Url::toRoute(['/checklist/item-form']); ?>',
                data: { index: $('.checklistItems .row').size() },
                cache: false,
                dataType: 'html'
            });

            return false;
        });

        $('body').on('click', '.checkitem-del', function() {
            $(this).closest(".row").remove();

            return false;
        });

        $('body').on('keypress', '.ch-item', function(e) {
            if(e.keyCode==13){
                $('.checklist-add').click();
                return false;
            }
        });
    });
</script>