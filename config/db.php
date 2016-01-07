<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yiimine',
    'username' => (YII_ENV == 'dev' ? 'root' : 'yiimine'),
    'password' => (YII_ENV == 'dev' ? '' : 'kjctFEjCFk'),
    'charset' => 'utf8',
    'enableQueryCache' => true,
    'enableSchemaCache' => true,
    'queryCacheDuration' => 3600 * 24,
];
