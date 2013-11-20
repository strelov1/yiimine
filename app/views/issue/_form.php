<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'issue-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
)); ?>

    <fieldset>
        <legend><?= ($model->isNewRecord) ? 'Создание новой задачи' : 'Редактирование задачи: ' . $model->subject; ?></legend>
        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->dropDownListRow($model, 'project_id', Project::getActiveProjects()); ?>

        <?php echo $form->radioButtonListRow($model, 'tracker_id', Issue::getTrackerOptions()); ?>

        <?php echo $form->dropDownListRow($model, 'priority_id', Issue::getPriorityOptions()); ?>

        <?php echo $form->dropDownListRow($model, 'assigned_to_id', User::getActiveUsers(), array('empty' => ' - ')); ?>

        <?php echo $form->textFieldRow($model, 'subject', array('class' => 'span5', 'maxlength' => 50)); ?>

        <?php echo $form->markdownEditorRow($model, 'description', array('height' => '200px')); ?>

        <?php echo $form->dropDownListRow($model, 'done_ratio', Issue::getDoneRatioOptions(), array('class' => 'span1')); ?>

        <?php echo $form->datepickerRow($model, 'due_date', array(
                'options' => array('language' => 'ru', 'format' => 'dd/mm/yyyy'),
                'prepend' => '<i class="icon-calendar"></i>',
        )); ?>

        <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => $model->isNewRecord ? 'Создать' : 'Сохранить',
            )); ?>
        </div>
    </fieldset>

<?php $this->endWidget(); ?>