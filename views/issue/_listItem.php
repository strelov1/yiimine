<?php
use yii\helpers\Html;
?>
<div class="row m-b-10">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-addon"><?= $index+1; ?></div>
            <?= Html::activeTextInput($model, "[$index]item", ['class' => 'form-control ch-item']); ?>
            <?= Html::activeHiddenInput($model, "[$index]status_id"); ?>
            <div class="input-group-addon">
                <a href="#" class="checkitem-del"><i class="fa fa-times text-danger"></i></a>
            </div>
        </div>

    </div>
</div>