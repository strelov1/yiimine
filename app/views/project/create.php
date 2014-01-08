<?php
$this->menu = array(
    array('label' => 'Управление', 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Список проектов', 'url' => $this->createUrl('index')),
    array('label' => 'Создать', 'url' => $this->createUrl('create'), 'itemOptions' => array('class' => 'active')),
);

$this->renderPartial('_form', array('model' => $model));