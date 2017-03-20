<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=yiimine',
    'username' => 'yiimine',
    'password' => 'yiimine_pass',
    'charset' => 'utf8',
    'enableQueryCache' => true,
    'enableSchemaCache' => true,
    'queryCacheDuration' => 3600 * 24,
];
