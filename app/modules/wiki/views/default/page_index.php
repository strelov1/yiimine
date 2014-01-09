<?php
$this->breadcrumbs = array(
    $project->title => array('/project/view', 'url' => $project->identifier),
    'Wiki' => array('/wiki'),
    'Index'
);

$this->menu = array(
    array('label' => $project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki'), 'itemOptions' => array('class' => 'active')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Создать запись', 'url' => $this->createUrl('edit', array('uid' => 'index'))),
);
?>

<?php /** @var $pages WikiPage[] */?>
<?php $namespace=null?>
<ol>
<?php foreach($pages as $page):?>
	<?php if($page->namespace != $namespace):?>
		</ol>
		<h2><?php echo $page->namespace ?></h2>
		<ol>
	<?php $namespace = $page->namespace; endif?>
	<li>
		<?php echo CHtml::link(CHtml::encode($page->page_uid), array('view', 'uid' => $page->page_uid))?>
	</li>
<?php endforeach?>
</ol>