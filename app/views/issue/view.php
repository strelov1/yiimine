<?php
$this->breadcrumbs = array(
    $model->project->title => array('/project/view', 'url' => $model->project->identifier),
    'Задачи' => array('/issue'),
    $model->subject,
);

$this->menu = array(
    array('label' => $model->project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $model->project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Создать задачу', 'url' => $this->createUrl('create')),
);

$this->renderPartial('application.views.common._flashMessage');

$box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => $model->subject,
        'headerIcon' => 'icon-tasks',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'primary',
                'buttons' => array(
                    array('label' => 'Закрыть', 'url' => array('/issue/close', 'id' => $model->id), 'htmlOptions' => array('class' => 'closeIssueBtn getForm')),
                    array(
                        'items' => array(
                            array('label' => 'Изменить статус', 'url' => array('/issue/changeStatus', 'issueId' => $model->id), 'linkOptions' => array('class' => 'changeStatusBtn getForm')),
                            array('label' => 'Изменить готовность', 'url' => array('/issue/changeDoneRatio', 'issueId' => $model->id), 'linkOptions' => array('class' => 'changeDoneRatioBtn getForm')),
                            '---',
                            array('label' => 'Редактировать', 'url' => array('/issue/update', 'id' => $model->id), 'visible' => ($model->author_id == Yii::app()->user->id) ? true : false),
                        )
                    ),
                )
            ),
        )
    )
); ?>
    <div class="row-fluid">
        <p>Добавил(а) <i><?= $model->author->username; ?>, <?= TimespanHelper::getTime(strtotime($model->created_date)); ?></i></p>

        <div class="span6">
            <?php
            $this->widget('bootstrap.widgets.TbDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'label' => 'Проект',
                            'value' => $model->project->title,
                        ),
                        array(
                            'name' => 'tracker_id',
                            'type' => 'html',
                            'value' => function ($data) {
                                    if ($data->tracker_id == Issue::TRACKER_BUG)
                                        return '<span class="label label-important">bug</span>';
                                    else
                                        return '<span class="label label-info">feature</span>';
                                }
                        ),
                        array(
                            'name' => 'status_id',
                            'type' => 'html',
                            'value' => function ($data) {
                                    if ($data->status_id == Issue::STATUS_NEW)
                                        return '<span class="badge badge-success">new</span>';
                                    elseif ($data->status_id == Issue::STATUS_CLOSED)
                                        return '<span class="badge badge-inverse">closed</span>';
                                    elseif ($data->status_id == Issue::STATUS_CANT_REPRODUCE)
                                        return '<span class="badge badge-warning">can\'t</span>';
                                    elseif ($data->status_id == Issue::STATUS_IN_WORK)
                                        return '<span class="badge badge-info">work</span>';
                                    elseif ($data->status_id == Issue::STATUS_REVIEW)
                                        return '<span class="badge">review</span>';
                                }
                        ),
                        array(
                            'name' => 'priority_id',
                            'type' => 'html',
                            'value' => function ($data) {
                                    if ($data->priority_id == Issue::PRIORITY_HIGH)
                                        return '<span class="label label-important">high</span>';
                                    elseif ($data->priority_id == Issue::PRIORITY_MEDIUM)
                                        return '<span class="label label-warning">medium</span>';
                                    else
                                        return '<span class="label label-label">low</span>';
                                }
                        ),
                    ),
                )
            );
            ?>
        </div>
        <div class="span5">
            <?php
            $this->widget('bootstrap.widgets.TbDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'name' => 'assigned_to_id',
                            'value' => function ($data) {
                                    if ($data->assigned)
                                        return $data->assigned->username;
                                    else
                                        return '-';
                                }
                        ),
                        array(
                            'name' => 'done_ratio',
                            'value' => function ($data) {
                                    if (!empty($data->done_ratio))
                                        return $data->done_ratio;
                                    else
                                        return '-';
                                }
                        ),
                        array(
                            'name' => 'due_date',
                            'value' => function ($data) {
                                    if ($data->due_date != '0000-00-00')
                                        return $data->due_date;
                                    else
                                        return '-';
                                }
                        ),
                    ),
                )
            );
            ?>
        </div>
    </div>
    <hr/>

<?php
$this->beginWidget('CHtmlPurifier');
    echo $model->description;
$this->endWidget();

if ($model->files) {
    foreach ($model->files as $file) {
        echo l(
            img($model->getThumbFilePath() . $file->filename, $model->subject, 140, 140, array('class' => 'img-polaroid', 'style' => 'margin-right: 10px;')),
            $model->getOrigFilePath() . $file->filename,
            array(
                'class' => 'fancybox',
                'rel' => 'gallery'.$model->id,
            )
        );
    }
}

$this->endWidget();

$this->renderPartial('application.views.common._flashMessage');

$this->renderPartial('_listComment', array('comments' => $comments));

$this->widget('AddCommentWidget', array('issueId' => $model->id));