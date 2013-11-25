<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'issue-close',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
)); ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Заркыть задачу #<?= $issue->id; ?></h3>
    </div>
    <div class="modal-body">
        <?php echo $form->textAreaRow($model,'text',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary sendForm"><i class="icon-ok icon-white"></i> Закрыть</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
    </div>

<?php $this->endWidget(); ?>