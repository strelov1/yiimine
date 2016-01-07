<?php
/**
 * @var $model app\models\Issue
 */
use app\components\enums\PriorityEnum;
use app\components\enums\StatusEnum;
use app\components\enums\TrackerEnum;
use app\models\Issue;
use kartik\date\DatePicker;
use yii\helpers\Html;
use kartik\editable\Editable;

$this->title = \Yii::t('app', 'Issue').' #'.$model->id.' - '.$model->subject.' - '.$this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $model->project]);

echo $this->render('_form', ['model' => $model, 'checklistItems' => $checklistItems]);