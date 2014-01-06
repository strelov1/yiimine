<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'issue-changeStatus',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    )); ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Изменить статус задачи #<?= $issue->id; ?></h3>
    </div>
    <div class="modal-body">
        <?php echo $form->dropDownListRow($issue, 'status_id', Issue::getStatusOptions()); ?>
        <?php echo $form->textAreaRow($comment,'text',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary sendForm"><i class="icon-ok icon-white"></i> Сохранить</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
    </div>

<?php $this->endWidget(); ?>