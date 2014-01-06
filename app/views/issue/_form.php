<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'issue-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    )
); ?>

    <fieldset>
        <legend><?= ($model->isNewRecord) ? 'Создание новой задачи'
                : 'Редактирование задачи: ' . $model->subject; ?></legend>
        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->dropDownListRow($model, 'project_id', Project::getActiveProjects()); ?>

        <?php echo $form->radioButtonListRow($model, 'tracker_id', Issue::getTrackerOptions()); ?>

        <?php echo $form->dropDownListRow($model, 'priority_id', Issue::getPriorityOptions()); ?>

        <?php echo $form->dropDownListRow($model, 'assigned_to_id', User::getActiveUsers(), array('empty' => ' - ')); ?>

        <?php echo $form->textFieldRow($model, 'subject', array('class' => 'span5', 'maxlength' => 50)); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $this->widget('application.extensions.tinymce.ETinyMce', array(
                    'model' => $model,
                    'attribute' => 'description',
                    'editorTemplate' => 'custom',
                    'language' => 'ru',
                    'height' => '200px'
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'tmpFiles', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('CMultiFileUpload', array(
                    'model' => $model,
                    'attribute' => 'tmpFiles',
                    'accept' => 'jpg|png|jpeg',
                    'denied' => 'Разрешены только jpg и png файлы',
                    'max' => 100,
                    'duplicate' => 'Этот файл уже выбран',
                    'htmlOptions' => array('multiple' => 'multiple')
                ));
                ?>
                <p class="hint">jpg, png</p>

                <?php
                if ($model->files) {
                    $this->renderPartial('_fileGrid', array('model' => $model));
                }
                ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'done_ratio', Issue::getDoneRatioOptions(), array('class' => 'span1', 'empty' => ' - ')); ?>

        <?php echo $form->datepickerRow($model, 'due_date', array(
                'options' => array('language' => 'ru', 'format' => 'dd/mm/yyyy'),
                'prepend' => '<i class="icon-calendar"></i>',
            )
        ); ?>

        <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type'       => 'primary',
                    'label'      => $model->isNewRecord ? 'Создать' : 'Сохранить',
                )
            ); ?>
        </div>
    </fieldset>

<?php $this->endWidget(); ?>