<?php
namespace app\components\enums;

use app\components\Enumeration;

class TrackerEnum extends Enumeration
{
    const TASK = 1;
    const BUG = 2;

    public static function i($className = __CLASS__)
    {
        return parent::i($className);
    }

    public function getLabels()
    {
        return array(
            'TASK' => \Yii::t('app', 'Task'),
            'BUG' => \Yii::t('app', 'Bug'),
        );
    }
}