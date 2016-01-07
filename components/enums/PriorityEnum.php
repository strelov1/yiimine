<?php
namespace app\components\enums;
use app\components\Enumeration;

class PriorityEnum extends Enumeration
{
    const LOW = 1;
    const NORMAL = 2;
    const HIGH = 3;
    const URGENT = 4;
    const IMMEDIATELY = 5;

    public static function i($className = __CLASS__)
    {
        return parent::i($className);
    }

    public function getLabels()
    {
        return array(
            'LOW' => \Yii::t('app', 'Low'),
            'NORMAL' => \Yii::t('app', 'Normal'),
            'HIGH' => \Yii::t('app', 'High'),
            'URGENT' => \Yii::t('app', 'Urgent'),
            'IMMEDIATELY' => \Yii::t('app', 'Immediately'),
        );
    }
}