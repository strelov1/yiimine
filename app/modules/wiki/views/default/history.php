<?php
$this->breadcrumbs = array(
    $project->title => array('/project/view', 'url' => $project->identifier),
    'Wiki' => array('/wiki/default/pageIndex'),
    'История'
);

$this->menu = array(
    array('label' => $project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki/default/pageIndex'), 'itemOptions' => array('class' => 'active')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Создать запись', 'url' => $this->createUrl('create')),
);
?>

    <h1><?php echo CHtml::link(CHtml::encode($page->getWikiUid()), array('view', 'uid' => $page->getWikiUid())) ?> <?php echo Yii::t('wiki', 'version history') ?></h1>

<?php echo CHtml::beginForm() ?>
    <table class="table">
        <tr>
            <th></th>
            <th>Revision</th>
            <th>Created at</th>
            <th>Comment</th>
        </tr>
        <?php foreach ($revisions as $revision): ?>
            <tr>
                <td><?php echo CHtml::checkBox('r' . $revision->id) ?></td>
                <td><?php echo CHtml::link('r' . $revision->id, array('view', 'uid' => $page->page_uid, 'rev' => $revision->id)) ?></td>
                <td><?php echo Yii::app()->format->formatDatetime($revision->created_at) ?></td>
                <td><?php echo CHtml::encode($revision->comment) ?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <div>
        <?php echo CHtml::submitButton(Yii::t('wiki', 'Show diff'), array('class' => 'btn')); ?>
    </div>
<?php echo CHtml::endForm() ?>