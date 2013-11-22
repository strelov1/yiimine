<div class="row-fluid">
    <div class="span2">
        <i><?= $data->user->username; ?></i><br/>
        <?= $data->created_date; ?>
    </div>
    <div class="span9">
        <?= nl2br(CHtml::encode($data->text)); ?>
    </div>
</div>
<hr/>