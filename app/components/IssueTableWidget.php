<?php

class IssueTableWidget extends CWidget
{
    public $projectId;

    public function init()
    {
        $sql = 'SELECT id, tracker_id, subject FROM issue WHERE project_id=:projectId AND status_id=:statusId ORDER BY id DESC LIMIT 5';

        $open = Yii::app()->db->createCommand($sql)->queryAll(true, array(':projectId' => $this->projectId, ':statusId' => Issue::STATUS_NEW));
        $inWork = Yii::app()->db->createCommand($sql)->queryAll(true, array(':projectId' => $this->projectId, ':statusId' => Issue::STATUS_IN_WORK));
        $closed = Yii::app()->db->createCommand($sql)->queryAll(true, array(':projectId' => $this->projectId, ':statusId' => Issue::STATUS_CLOSED));

        $this->render('issueTableWidget', array('open' => $open, 'inWork' => $inWork, 'closed' => $closed));
    }
} 