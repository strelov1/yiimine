<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $comments,
    'itemView' => '__itemListComment',
    'template' => '{sorter}{items}{pager}',
    'sorterHeader' => 'Сортировать комментарии по:',
    'emptyText' => '',
    'sortableAttributes' => array(
        'created_date' => 'Дате',
    ),
));