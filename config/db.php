<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=yiimine',
    'username' => (YII_ENV == 'dev' ? 'dev' : 'yiimine'),
    'password' => (YII_ENV == 'dev' ? '' : 'kjctFEjCFk'),
    'charset' => 'utf8',
    'enableQueryCache' => true,
    'enableSchemaCache' => true,
    'queryCacheDuration' => 3600 * 24,
];
