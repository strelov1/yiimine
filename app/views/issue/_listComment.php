<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $comments,
    'itemView' => '__itemListComment',
    'template' => '{sorter}{items}{pager}',
    'sorterHeader' => 'Сортировать по:',
    'sortableAttributes' => array(
        'created_date' => 'Дате',
    ),
));