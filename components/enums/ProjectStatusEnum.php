<?php
namespace app\components\enums;
use app\components\Enumeration;

class ProjectStatusEnum extends Enumeration
{
    const OPEN = 1;
    const CLOSED = 0;

    public static function i($className = __CLASS__)
    {
        return parent::i($className);
    }

    public function getLabels()
    {
        return array(
            'OPEN' => \Yii::t('app', 'Open'),
            'CLOSED' => \Yii::t('app', 'Closed'),
        );
    }
}