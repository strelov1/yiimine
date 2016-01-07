<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'layout' => 'inline'
]);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <span class="input-group-addon">Новая заметка</span>
            <?php echo $form->field($model, 'description')->textInput(['style' => 'width: 500px;']); ?>
            <span class="input-group-btn">
                <?php echo Html::submitButton(($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Save')), ['class' => 'btn btn-primary']); ?>
            </span>
        </div>
    </div>
</div>
<?php
ActiveForm::end();
echo '<br />';
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'description',
        'created_date',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
        ],
    ],
]);