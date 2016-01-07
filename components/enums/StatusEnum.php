<?php
namespace app\components\enums;
use app\components\Enumeration;

class StatusEnum extends Enumeration
{
    const NEW_ISSUE = 1;
    const IN_WORK = 2;
    const DONE = 3;
    const FEEDBACK = 4;
    const CLOSED = 5;
    const REJECTED = 6;

    public static function i($className = __CLASS__)
    {
        return parent::i($className);
    }

    public function getLabels()
    {
        return array(
            'NEW_ISSUE' => \Yii::t('app', 'New'),
            'IN_WORK' => \Yii::t('app', 'In Work'),
            'DONE' => \Yii::t('app', 'Done'),
            'FEEDBACK' => \Yii::t('app', 'Feedback'),
            'CLOSED' => \Yii::t('app', 'Closed'),
            'REJECTED' => \Yii::t('app', 'Rejected'),
        );
    }

    public static function getClosedStatuses()
    {
        return [self::CLOSED, self::DONE];
    }

    public static function getOpenStatuses()
    {
        return [self::NEW_ISSUE, self::FEEDBACK, self::REJECTED];
    }
}